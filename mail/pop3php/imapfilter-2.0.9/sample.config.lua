---------------
--  Options  --
---------------

options.timeout = 120
options.subscribe = true


----------------
--  Accounts  --
----------------

-- Connects to "imap1.mail.server", as user "user1" with "secret1" as
-- password.
account1 = IMAP {
    server = 'imap1.mail.server',
    username = 'user1',
    password = 'secret1',
}

-- Another account which connects to the mail server using the SSLv3
-- protocol.
account2 = IMAP {
    server = 'imap2.mail.server',
    username = 'user2',
    password = 'secret2',
    ssl = 'ssl3',
}

-- Get a list of the available mailboxes and folders
mailboxes, folders = account1:list_all()

-- Get a list of the subscribed mailboxes and folders
mailboxes, folders = account1:list_subscribed()

-- Create a mailbox
account1:create_mailbox('Friends')

-- Subscribe a mailbox
account1:subscribe_mailbox('Friends')


-----------------
--  Mailboxes  --
-----------------

-- Get the status of a mailbox
account1.INBOX:check_status()

-- Get all the messages in the mailbox.
result = account1.INBOX:select_all()

-- Get newly arrived, unread messages
result = account1.INBOX:is_new()

-- Get unseen messages with the specified "From" header.
result = account1.INBOX:is_unseen() *
         account1.INBOX:contain_from('weekly-news@news.letter')

-- Copy messages between mailboxes at the same account.
account1.INBOX:copy_messages(account1.news, result)

-- Get messages with the specified "From" header but without the
-- specified "Subject" header.
result = account1.INBOX:contain_from('announce@my.unix.os') -
         account1.INBOX:contain_subject('security advisory')

-- Copy messages between mailboxes at a different account.
account1.INBOX:copy_messages(account2.security, result)

-- Get messages with any of the specified headers.
result = account1.INBOX:contain_from('marketing@company.junk') +
         account1.INBOX:contain_from('advertising@annoying.promotion') +
         account1.INBOX:contain_subject('new great products')

-- Get messages matching matching the specified regular expression in
-- the header.
result = account1.INBOX:match_header('^.+MailScanner.*Check: [Ss]pam$')

-- Delete messages.
account1.INBOX:delete_messages(result)

-- Get messages with the specified "Sender" header, which are older than
-- 30 days.
result = account1.INBOX:contain_field('sender', 'owner@announce-list') *
         account1.INBOX:is_older(30)

-- Move messages to the "announce" mailbox inside the "lists" folder.
account1.INBOX:move_messages(account1['lists/announce'], result)

-- Get messages, in the "devel" mailbox inside the "lists" folder, with the
-- specified "Subject" header and a size less than 50000 octets (bytes).
result = account1['lists/devel']:contain_subject('[patch]') *
         account1['lists/devel']:is_smaller(50000)

-- Move messages from the "devel" mailbox inside the "lists" folder.
account1['lists/devel']:move_messages(account2.patch, result)

-- Get recent, unseen messages, that have either one of the specified
-- "From" headers, but do not have the specified pattern in the body of
-- the message.
result = ( account1.INBOX:is_recent() *
           account1.INBOX:is_unseen() *
           ( account1.INBOX:contain_from('tux@penguin.land') +
             account1.INBOX:contain_from('beastie@daemon.land') ) ) -
         account1.INBOX:match_body('.*all.work.and.no.play.*')

-- Mark messages.
account1.INBOX:mark_seen(account1, result)

