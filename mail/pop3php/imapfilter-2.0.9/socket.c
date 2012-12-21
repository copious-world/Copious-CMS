#include <stdio.h>
#include <unistd.h>
#include <string.h>
#include <strings.h>
#include <errno.h>
#include <netinet/in.h>
#include <netdb.h>
#include <sys/socket.h>
#include <sys/types.h>
#include <sys/time.h>
#include <sys/select.h>

#include "imapfilter.h"
#include "session.h"

#ifndef NO_SSLTLS
#include <openssl/ssl.h>
#include <openssl/err.h>
#endif


/*
 * Connect to mail server.
 */
int
open_connection(session *ssn, const char *server, const char *port,
    const char *protocol)
{
	struct addrinfo hints, *res, *ressave;
	int n, sockfd;

#ifdef NO_SSLTLS
	if (protocol) {
		error("SSL not supported by this build\n");
		return -1;
	}
#endif

	memset(&hints, 0, sizeof(struct addrinfo));

	hints.ai_family = AF_UNSPEC;
	hints.ai_socktype = SOCK_STREAM;

	n = getaddrinfo(server, port, &hints, &res);

	if (n < 0) {
		error("gettaddrinfo; %s\n", gai_strerror(n));
		return -1;
	}

	ressave = res;

	sockfd = -1;

	while (res) {
		sockfd = socket(res->ai_family, res->ai_socktype,
		    res->ai_protocol);

		if (sockfd >= 0) {
			if (connect(sockfd, res->ai_addr, res->ai_addrlen) == 0)
				break;

			sockfd = -1;
		}
		res = res->ai_next;
	}

	if (ressave)
		freeaddrinfo(ressave);

	if (sockfd == -1) {
		error("error while initiating connection to %s at port %s\n",
		    server, port);
		return -1;
	}

	ssn->socket = sockfd;

#ifndef NO_SSLTLS
	if (protocol) {
		if (open_secure_connection(ssn, server, port, protocol) == -1) {
			close_connection(ssn);
			return -1;
		}
	}
#endif

	return ssn->socket;
}


#ifndef NO_SSLTLS
/*
 * Initialize SSL/TLS connection.
 */
int
open_secure_connection(session *ssn, const char *server, const char *port,
    const char *protocol)
{
	int e;
	SSL_CTX *ctx;
	SSL_METHOD *method;

	method = NULL;

	if (!strncasecmp(protocol, "tls1", 4))
		method = TLSv1_client_method();
	else if (!strncasecmp(protocol, "ssl3", 4) ||
	    !strncasecmp(protocol, "ssl2", 4))
		method = SSLv23_client_method();

	if (!(ctx = SSL_CTX_new(method)))
		goto fail;

	if (!(ssn->ssl = SSL_new(ctx)))
		goto fail;

	SSL_set_fd(ssn->ssl, ssn->socket);

	if ((e = SSL_connect(ssn->ssl)) <= 0) {
		SSL_get_error(ssn->ssl, e);
		error("initiating SSL connection to %s at port %s; %s\n",
		    server, port, ERR_error_string(ERR_get_error(), NULL));
		goto fail;
	}
	if (get_cert(ssn) == -1)
		goto fail;

	SSL_CTX_free(ctx);

	return 0;

fail:
	ssn->ssl = NULL;
	SSL_CTX_free(ctx);

	return -1;
}
#endif				/* NO_SSLTLS */


/*
 * Disconnect from mail server.
 */
int
close_connection(session *ssn)
{
	int r;

	r = 0;

#ifndef NO_SSLTLS
	close_secure_connection(ssn);
#endif

	if (ssn->socket != -1) {
		r = close(ssn->socket);
		ssn->socket = -1;

		if (r == -1)
			error("closing socket; %s\n", strerror(errno));
	}
	return r;
}


#ifndef NO_SSLTLS
/*
 * Shutdown SSL/TLS connection.
 */
int
close_secure_connection(session *ssn)
{

	if (ssn->ssl) {
		SSL_shutdown(ssn->ssl);
		SSL_free(ssn->ssl);
		ssn->ssl = NULL;
	}

	return 0;
}
#endif


/*
 * Read data from socket.
 */
ssize_t
socket_read(session *ssn, char *buf, size_t len)
{
	int s, t;
	ssize_t r;
	fd_set fds;

	struct timeval tv;

	struct timeval *tvp;

	r = 0;
	s = 1;
	tvp = NULL;

	memset(buf, 0, len + 1);

	t = (int)(get_option_number("timeout"));
	if (t > 0) {
		tv.tv_sec = t;
		tv.tv_usec = 0;
		tvp = &tv;
	}

	FD_ZERO(&fds);
	FD_SET(ssn->socket, &fds);
 
#ifndef NO_SSLTLS
	if (ssn->ssl) {
		if (SSL_pending(ssn->ssl) > 0 ||
		    ((s = select(ssn->socket + 1, &fds, NULL, NULL, tvp)) > 0 &&
		    FD_ISSET(ssn->socket, &fds))) {
			r = socket_secure_read(ssn, buf, len);

			if (r <= 0)
				goto fail;
		}
	} else
#endif
	{
		if ((s = select(ssn->socket + 1, &fds, NULL, NULL, tvp)) > 0 &&
		    FD_ISSET(ssn->socket, &fds)) {
			r = read(ssn->socket, buf, len);

			if (r == -1) {
				error("reading data; %s\n", strerror(errno));
				goto fail;
			} else if (r == 0) {
				goto fail;
			}
		}
	}

	if (s == -1) {
		error("waiting to read from socket; %s\n", strerror(errno));
		goto fail;
	} else if (s == 0) {
		error("timeout period expired while waiting to read data\n");
		goto fail;
	}

	return r;
fail:
	close_connection(ssn);

	return -1;

}


#ifndef NO_SSLTLS
/*
 * Read data from a TLS/SSL connection.
 */
ssize_t
socket_secure_read(session *ssn, char *buf, size_t len)
{
	int r;

	for (;;) {
		r = (ssize_t) SSL_read(ssn->ssl, buf, len);

		if (r > 0)
			break;

		switch (SSL_get_error(ssn->ssl, r)) {
		case SSL_ERROR_WANT_READ:
		case SSL_ERROR_WANT_WRITE:
			continue;
		case SSL_ERROR_ZERO_RETURN:
			return 0;
		case SSL_ERROR_SYSCALL:
		case SSL_ERROR_SSL:
			error("reading data; %s\n",
			    ERR_error_string(ERR_get_error(), NULL));
			return -1;
		default:
			return -1;
		}
	}

	return r;
}
#endif


/*
 * Write data to socket.
 */
ssize_t
socket_write(session *ssn, const char *buf, size_t len)
{
	int s, t;
	ssize_t w, wt;
	fd_set fds;

	struct timeval tv;

	struct timeval *tvp = NULL;

	w = wt = 0;
	s = 1;

	t = (int)(get_option_number("timeout"));
	if (t > 0)
		tvp = &tv;

	FD_ZERO(&fds);
	FD_SET(ssn->socket, &fds);

	while (len) {
		if (t > 0) {
			tv.tv_sec = t;
			tv.tv_usec = 0;
		}

		if ((s = select(ssn->socket + 1, NULL, &fds, NULL, tvp) > 0 &&
		    FD_ISSET(ssn->socket, &fds))) {
#ifndef NO_SSLTLS
			if (ssn->ssl) {
				w = socket_secure_write(ssn, buf, len);

				if (w <= 0)
					goto fail;
			} else
#endif
			{
				w = write(ssn->socket, buf, len);

				if (w == -1) {
					error("writing data; %s\n",
					    strerror(errno));
					goto fail;
				} else if (w == 0) {
					goto fail;
				}
			}

			if (w > 0) {
				len -= w;
				buf += w;
				wt += w;
			}
		}
	}

	if (s == -1) {
		error("waiting to write to socket; %s\n", strerror(errno));
		goto fail;
	} else if (s == 0) {
		error("timeout period expired while waiting to write data\n");
		goto fail;
	}

	return wt;
fail:
	close_connection(ssn);

	return -1;
}


#ifndef NO_SSLTLS
/*
 * Write data to a TLS/SSL connection.
 */
ssize_t
socket_secure_write(session *ssn, const char *buf, size_t len)
{
	int w;

	for (;;) {
		w = (ssize_t) SSL_write(ssn->ssl, buf, len);

		if (w > 0)
			break;

		switch (SSL_get_error(ssn->ssl, w)) {
		case SSL_ERROR_WANT_READ:
		case SSL_ERROR_WANT_WRITE:
			continue;
		case SSL_ERROR_ZERO_RETURN:
			return 0;
		case SSL_ERROR_SYSCALL:
		case SSL_ERROR_SSL:
			error("writing data; %s\n",
			    ERR_error_string(ERR_get_error(), NULL));
			return -1;
		default:
			return -1;
		}
	}

	return w;
}
#endif
