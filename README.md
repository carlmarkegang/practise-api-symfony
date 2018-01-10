# To get started
```
$ composer install
```

setup app/config/parameters.yml

```
$ php bin/console doctrine:schema:update --force
```

Testdata
```
insert into post (text,type,parent,created,updated,user_id,deleted,contains_img,count_sub_posts) values("text","main","",1515572252,"",1,"","",0);
insert into post (text,type,parent,created,updated,user_id,deleted,contains_img,count_sub_posts) values("sub","sub",1,1515572252,"",1,"","",0);
insert into users (id,username,password,token) values (null,"carl","pass","token");

```
