#ifndef NO_SSLTLS

#include <stdio.h>
#include <string.h>
#include <ctype.h>
#include <limits.h>
#include <sys/stat.h>

#include "imapfilter.h"
#include "session.h"
#include "pathnames.h"

#include <openssl/x509.h>
#include <openssl/ssl.h>
#include <openssl/pem.h>
#include <openssl/evp.h>


extern environment env;


int check_cert(X509 *pcert, unsigned char *pmd, unsigned int *pmdlen);
void print_cert(X509 *cert, unsigned char *md, unsigned int *mdlen);
int write_cert(X509 *cert);
int mismatch_cert(void);


/*
 * Get SSL/TLS certificate check it, maybe ask user about it and act
 * accordingly.
 */
int
get_cert(session *ssn)
{
	X509 *cert;
	unsigned char md[EVP_MAX_MD_SIZE];
	unsigned int mdlen;

	mdlen = 0;

	if (!(cert = SSL_get_peer_certificate(ssn->ssl)))
		return -1;

	if (!(X509_digest(cert, EVP_md5(), md, &mdlen)))
		return -1;

	switch (check_cert(cert, md, &mdlen)) {
	case 0:
		print_cert(cert, md, &mdlen);
		if (write_cert(cert) == -1)
			goto fail;
		break;
	case -1:
		print_cert(cert, md, &mdlen);
		if (mismatch_cert() == -1)
			goto fail;
		break;
	}

	X509_free(cert);

	return 0;

fail:
	X509_free(cert);

	return -1;
}


/*
 * Check if the SSL/TLS certificate exists in the certificates file.
 */
int
check_cert(X509 *pcert, unsigned char *pmd, unsigned int *pmdlen)
{
	int n, r;
	FILE *fd;
	char b;
	char *certf;
	X509 *cert;
	unsigned char md[EVP_MAX_MD_SIZE];
	unsigned int mdlen;

	r = 0;
	cert = NULL;

	n = snprintf(&b, 1, "%s/%s", env.home, PATHNAME_CERTS);

	if (env.pathmax != -1 && n > env.pathmax)
		fatal(ERROR_PATHNAME,
		    "pathname limit %ld exceeded: %d\n", env.pathmax, n);

	certf = (char *)xmalloc((n + 1) * sizeof(char));
	snprintf(certf, n + 1, "%s/%s", env.home, PATHNAME_CERTS);

	if (!exists_file(certf)) {
		xfree(certf);
		return 0;
	}

	fd = fopen(certf, "r");

	xfree(certf);

	if (fd == NULL)
		return -1;

	while ((cert = PEM_read_X509(fd, &cert, NULL, NULL)) != NULL) {
		if (X509_subject_name_cmp(cert, pcert) != 0 ||
		    X509_issuer_name_cmp(cert, pcert) != 0)
			continue;

		if (!X509_digest(cert, EVP_md5(), md, &mdlen) ||
		    *pmdlen != mdlen)
			continue;

		if (memcmp(pmd, md, mdlen) != 0) {
			r = -1;
			break;
		}
		r = 1;
		break;
	}

	fclose(fd);
	X509_free(cert);

	return r;
}


/*
 * Print information about the SSL/TLS certificate.
 */
void
print_cert(X509 *cert, unsigned char *md, unsigned int *mdlen)
{
	unsigned int i;
	char *c;

	c = X509_NAME_oneline(X509_get_subject_name(cert), NULL, 0);
	printf("Server certificate subject: %s\n", c);
	xfree(c);

	c = X509_NAME_oneline(X509_get_issuer_name(cert), NULL, 0);
	printf("Server certificate issuer: %s\n", c);
	xfree(c);

	printf("Server key fingerprint: ");
	for (i = 0; i < *mdlen; i++)
		printf(i != *mdlen - 1 ? "%02X:" : "%02X\n", md[i]);
}


/*
 * Write the SSL/TLS certificate after asking the user to accept/reject it.
 */
int
write_cert(X509 *cert)
{
	int n;
	FILE *fd;
	char b, c, buf[64];
	char *certf;

	do {
		printf("(R)eject, accept (t)emporarily or "
		    "accept (p)ermanently? ");
		fgets(buf, sizeof(buf), stdin);
		c = tolower((int)(*buf));
	} while (c != 'r' && c != 't' && c != 'p');

	if (c == 'r')
		return -1;
	else if (c == 't')
		return 0;

	n = snprintf(&b, 1, "%s/%s", env.home, PATHNAME_CERTS);

	if (env.pathmax != -1 && n > env.pathmax)
		fatal(ERROR_PATHNAME,
		    "pathname limit %ld exceeded: %d\n", env.pathmax, n);

	certf = (char *)xmalloc((n + 1) * sizeof(char));
	snprintf(certf, n + 1, "%s/%s", env.home, PATHNAME_CERTS);

	create_file(certf, S_IRUSR | S_IWUSR);

	fd = fopen(certf, "a");

	xfree(certf);

	if (fd == NULL)
		return -1;

	PEM_write_X509(fd, cert);

	fclose(fd);

	return 0;
}


/*
 * Ask user to proceed, while a fingerprint mismatch in the SSL/TLS certificate
 * was found.
 */
int
mismatch_cert(void)
{
	char c, buf[64];

	do {
		printf("ATTENTION: SSL/TLS certificate fingerprint mismatch.\n"
		    "Proceed with the connection (y/n)? ");
		fgets(buf, sizeof(buf), stdin);
		c = tolower((int)(*buf));
	} while (c != 'y' && c != 'n');

	if (c == 'y')
		return 0;
	else
		return -1;
}
#endif				/* NO_SSLTLS */
