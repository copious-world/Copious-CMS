#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <errno.h>
#include <limits.h>
#include <sys/stat.h>
#include <locale.h>

#include "imapfilter.h"
#include "session.h"
#include "list.h"
#include "version.h"
#include "buffer.h"
#include "pathnames.h"
#include "regexp.h"

#ifndef NO_SSLTLS
#include <openssl/ssl.h>
#include <openssl/err.h>
#endif


extern buffer ibuf, obuf, nbuf;
extern regexp responses[];

options opts;			/* Program options. */
environment env;		/* Environment variables. */

list *sessions = NULL;		/* Active IMAP sessions. */

void usage(void);
void version(void);


/*
 * IMAPFilter: an IMAP mail filtering utility.
 */
int
main(int argc, char *argv[])
{
	int c;

	setlocale(LC_CTYPE, "");

	opts.debug = 0;
	opts.verbose = 0;
	opts.interactive = 0;
	opts.log = NULL;
	opts.config = NULL;
	opts.oneline = NULL;

	env.home = getenv("HOME");
	env.pathmax = -1;

	while ((c = getopt(argc, argv, "Vc:de:il:v?")) != -1) {
		switch (c) {
		case 'V':
			version();
			/* NOTREACHED */
		case 'c':
			opts.config = optarg;
			break;
		case 'd':
			if (opts.debug < 2)
				opts.debug++;
			break;
		case 'e':
			opts.oneline = optarg;
			break;
		case 'i':
			opts.interactive = 1;
			break;
		case 'l':
			opts.log = optarg;
			break;
		case 'v':
			opts.verbose = 1;
			break;
		case '?':
		default:
			usage();
			/* NOTREACHED */
		}
	}

	get_pathmax();

	open_debug();

	create_homedir();

	catch_signals();

	open_log();

	buffer_init(&ibuf, INPUT_BUF);
	buffer_init(&obuf, OUTPUT_BUF);
	buffer_init(&nbuf, NAMESPACE_BUF);

	if (opts.config == NULL) {
		int n;
		char b;

		n = snprintf(&b, 1, "%s/%s", env.home, PATHNAME_CONFIG);

		if (env.pathmax != -1 && n > env.pathmax)
			fatal(ERROR_PATHNAME,
			    "pathname limit %ld exceeded: %d\n", env.pathmax,
			    n);

		opts.config = (char *)xmalloc((n + 1) * sizeof(char));
		snprintf(opts.config, n + 1, "%s/%s", env.home,
		    PATHNAME_CONFIG);
	}

	regexp_compile(responses);

#ifndef NO_SSLTLS
	SSL_library_init();
	SSL_load_error_strings();
#endif

	start_lua();

	{
		list *l;
		session *s;

		l = sessions;
		while (l != NULL) {
			s = l->data;
			l = l->next;

			response_generic(s, imap_logout(s));
			close_connection(s);
			session_destroy(s);
		}
	}

	stop_lua();

#ifndef NO_SSLTLS
	ERR_free_strings();
#endif

	regexp_free(responses);

	buffer_free(&ibuf);
	buffer_free(&obuf);
	buffer_free(&nbuf);

	close_log();
	close_debug();

	exit(0);
}


/*
 * Print a very brief usage message.
 */
void
usage(void)
{

	fprintf(stderr, "usage: imapfilter [-Vdiv] [-c configfile] "
	    "[-e 'command'] [-l logfile]\n");

	exit(0);
}


/*
 * Print program's version and copyright.
 */
void
version(void)
{

	fprintf(stderr, "IMAPFilter %s  %s\n", IMAPFILTER_VERSION,
	    IMAPFILTER_COPYRIGHT);

	exit(0);
}
