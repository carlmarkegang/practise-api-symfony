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
 insert into post (id,user_id,text,type,parent,created,updated,deleted,contains_img,count_sub_posts) values (1,1,"text","main",0,1516217123,"","","",0);
  insert into post (id,user_id,text,type,parent,created,updated,deleted,contains_img,count_sub_posts) values (NULL,1,"text","sub",1,1516217123,"","","",0);
insert into users (id,username,password,token) values (null,"carl","pass","token");

```
