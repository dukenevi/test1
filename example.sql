create table visitor_info
(
    id          int auto_increment
        primary key,
    ip_address  varchar(15)  not null,
    user_agent  varchar(255) null,
    view_date   varchar(20)  null,
    page_url    varchar(255) null,
    views_count int          not null
);

INSERT INTO db_test.visitor_info (id, ip_address, user_agent, view_date, page_url, views_count) VALUES (1, '91.208.153.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36', '2021-04-26__11:48:15', '/index2.html', 4);
INSERT INTO db_test.visitor_info (id, ip_address, user_agent, view_date, page_url, views_count) VALUES (2, '91.208.153.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36', '2021-04-26__11:48:06', '/index1.html', 3);