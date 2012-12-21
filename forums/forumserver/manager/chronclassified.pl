 
#!perl -w



use Net::HTTP;
 my $s = Net::HTTP->new(Host => "www.copious-systems.com") || die $@;
 $s->write_request(GET => "/classifieds/docclassifiedserver/manager/processadd.php", 'User-Agent' => "Mozilla/5.0");
 my($code, $mess, %h) = $s->read_response_headers;

 while (1) {
    my $buf;
    my $n = $s->read_entity_body($buf, 1024);
    die "read failed: $!" unless defined $n;
    last unless $n;
    print $buf;
 }


