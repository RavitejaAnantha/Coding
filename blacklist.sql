create external table hatescore (screen_name string, hate_score decimal(5,3)) row format delimited fields terminated by '\t' location '/user/cloudera/tweets/output/';

create external table hatefollowers (screen_name string, user_id bigint, followers_count int, tweet string) row format delimited fields terminated by '\t' location '/user/cloudera/tweets/followers/';

-- join 2 data collections
create table blacklist as select t1.screen_name, t1.hate_score, t2.followers_count from hatescore t1 join hatefollowers t2 on (t1.screen_name = t2.screen_name);

-- select count(*) from blacklist;

create table blacklist_sorted as select screen_name, hate_score, followers_count from blacklist order by hate_score, followers_count desc;

-- select distinct(screen_name), hate_score, followers_count from blacklist_sorted where hate_score >= 0.3;

-- move result to local FS
insert overwrite directory 'tweets/hiveoutput/' select concat(screen_name,'\t',hate_score,'\t',followers_count) from blacklist_sorted where hate_score >= 0.3;

