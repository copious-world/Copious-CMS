--
-- This file contains examples on how IMAPFilter can be extended using
-- the Lua programming language.
--


-- IMAPFilter can be detached from the controlling terminal and run in
-- the background as a system daemon.
--
-- The auxiliary function daemon_mode() is supplied for conveniency.
-- The following example puts imapfilter in the background and runs
-- endlessly, executing the commands in the forever() function and
-- sleeping for 600 seconds between intervals:

function forever()
    result = myaccount.mymailbox:is_old()
    myaccount.mymailbox:move_messages(myaccount.archive, result)
end

become_daemon(600, forever)


-- IMAPFilter can take advantage of all those filtering utilities that
-- are available and use a wide range of heuristic tests, text analysis,
-- internet-based realtime blacklists, advanced learning algorithms,
-- etc. to classify mail.  IMAPFilter can pipe a message to a program
-- and act on the message based on the program's exit status.
--
-- The auxiliary function pipe_to() is supplied for conveniency.  For
-- example if there was a utility named "bayesian-spam-filter", which
-- returned 1 when it considered the message "spam" and 0 otherwise:

result = myaccount.mymailbox:select_all()
messages = myaccount.mymailbox:fetch_message(result)

result = {}
for msgid, msgtxt in pairs(messages) do
    if (pipe_to('bayesian-spam-filter', msgtxt) == 1) then
        result[msgid] = true
    end
end

myaccount.mymailbox:delete_messages(result)


-- Passwords could be extracted during execution time from an encrypted
-- file.
--
-- The file is encrypted using the openssl(1) command line tool.  For
-- example the "passwords.txt" file:
--
--   secret1 secret2
--
-- ... is encrypted and saved to a file named "passwords.enc" with the
-- command:
--
--   $ openssl bf -salt -in passwords.txt -out passwords.enc
--
-- The auxiliary function pipe_from() is supplied for conveniency.  The
-- user is prompted to enter the decryption password, the file is
-- decrypted and the account passwords are set accordingly:

status, output = pipe_from('openssl bf -d -salt -in ~/passwords.enc')

_, _, password1, password2 = string.find(output, '(%w+)\n(%w+)\n')

account1 = IMAP {
    server = 'imap1.mail.server',
    username = 'user1',
    password = password1
}

account2 = IMAP {
    server = 'imap2.mail.server',
    username = 'user2',
    password = password2
}

