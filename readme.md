Tohle zdokumentuju zitra rano.


Hahahahaha

<b>git deploy bez ztraty requestu, s lockovanim, migracema, mazani cache atp</b>

```
http://git-scm.com/book/en/Git-on-the-Server-Setting-Up-the-Server
git remote add deploy git@31.31.25.25:/srv/repo/SITE.git
```

varnish podrzi requesty nez se restartuje php-fpm ale musi se poustet s parametrem `-p max_retries=1000"`
```
vcl 4.0;

# Default backend definition. Set this to point to your content server.
backend default {
    .host = "127.0.0.1";
    .port = "8080";
}

sub vcl_recv {
    if (!(req.url ~ "^/api")) {
        return (pass);
    }
    # else api
    unset req.http.cookie;
}

sub vcl_backend_response {
    set beresp.ttl = 60s;
    if (bereq.url ~ "/(tags|tag-types|venues|days)/") {
        set beresp.ttl = 420s;
    }
    if (bereq.url ~ "/users/\?|/users/\d+/\?") {
        set beresp.ttl = 10s;
    }
    if (beresp.status == 502 && bereq.retries < 500) {
        return (retry);
    }
    return (deliver);
}
```
