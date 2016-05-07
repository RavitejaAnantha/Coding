-- HIVE 2 input is group_id \t count

create external table hategroups (user_id string, followers_count int) row format delimited fields terminated by '\t' location '/user/cloudera/tweets/mr2output';

create table hategroups_sorted as select user_id, followers_count from hategroups order by followers_count desc;

insert overwrite directory 'tweets/hiveoutput2/' select concat(user_id,'\t',followers_count) from hategroups_sorted;

