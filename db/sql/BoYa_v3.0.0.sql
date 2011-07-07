/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     7/7/2011 6:32:58 PM                          */
/*==============================================================*/


drop function if exists getIntersetQuesAmt;

drop procedure if exists getMostSimilar;

drop function if exists getSimilarity;

drop function if exists getUnionQuesAmt;

drop procedure if exists insertSimilarProc;

drop table if exists Admin;

drop table if exists Answer;

drop table if exists Follow;

drop table if exists OperateQuestion;

drop table if exists OperateUser;

drop table if exists Question;

drop table if exists Similar;

drop table if exists User;

/*==============================================================*/
/* Table: Admin                                                 */
/*==============================================================*/
create table Admin
(
   A_ID                 char(10) not null,
   login_name           varchar(16) not null,
   admin_pw             varchar(16) not null,
   primary key (A_ID)
);

/*==============================================================*/
/* Table: Answer                                                */
/*==============================================================*/
create table Answer
(
   U_ID                 int not null,
   Q_ID                 int not null,
   answer_time          timestamp not null default CURRENT_TIMESTAMP,
   answer               enum('Y','N') not null,
   primary key (U_ID, Q_ID)
);

/*==============================================================*/
/* Table: Follow                                                */
/*==============================================================*/
create table Follow
(
   follower_ID          int not null,
   following_ID         int not null,
   follow_time          timestamp not null default CURRENT_TIMESTAMP,
   hasRead              enum('Y','N') not null,
   primary key (follower_ID, following_ID)
);

/*==============================================================*/
/* Table: OperateQuestion                                       */
/*==============================================================*/
create table OperateQuestion
(
   Q_ID                 int not null,
   A_ID                 char(10) not null,
   operate_time         timestamp not null default CURRENT_TIMESTAMP,
   operate_type         char(1) not null,
   primary key (Q_ID, A_ID)
);

/*==============================================================*/
/* Table: OperateUser                                           */
/*==============================================================*/
create table OperateUser
(
   U_ID                 int not null,
   A_ID                 char(10) not null,
   operateU_time        timestamp not null,
   operate_type         char(1) not null,
   primary key (U_ID, A_ID)
);

/*==============================================================*/
/* Table: Question                                              */
/*==============================================================*/
create table Question
(
   Q_ID                 int not null auto_increment,
   content              varchar(200) not null,
   Q_span               char(1),
   primary key (Q_ID)
);

/*==============================================================*/
/* Table: Similar                                               */
/*==============================================================*/
create table Similar
(
   S_ID                 int not null auto_increment,
   U_ID1                int not null,
   U_ID2                int not null,
   similarity           float not null,
   update_time          timestamp not null default CURRENT_TIMESTAMP,
   primary key (S_ID)
);

/*==============================================================*/
/* Table: User                                                  */
/*==============================================================*/
create table User
(
   U_ID                 int not null auto_increment,
   user_name            varchar(16) not null,
   user_pw              varchar(16) not null,
   email                varchar(32) not null,
   register_time        timestamp not null default CURRENT_TIMESTAMP,
   gender               enum('F','M'),
   birthday             date,
   website              varchar(50),
   primary key (U_ID)
);

/*==============================================================*/
/* Index: emailIndex                                            */
/*==============================================================*/
create unique index emailIndex on User
(
   email
);

/*==============================================================*/
/* Index: nameIndex                                             */
/*==============================================================*/
create unique index nameIndex on User
(
   user_name
);

alter table Answer add constraint FK_Answered foreign key (Q_ID)
      references Question (Q_ID) on delete restrict on update restrict;

alter table Answer add constraint FK_Answers foreign key (U_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table Follow add constraint FK_Followed foreign key (following_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table Follow add constraint FK_Follows foreign key (follower_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table OperateQuestion add constraint FK_Operated foreign key (Q_ID)
      references Question (Q_ID) on delete restrict on update restrict;

alter table OperateQuestion add constraint FK_Operates foreign key (A_ID)
      references Admin (A_ID) on delete restrict on update restrict;

alter table OperateUser add constraint FK_OperateUser foreign key (A_ID)
      references Admin (A_ID) on delete restrict on update restrict;

alter table OperateUser add constraint FK_OperateUser2 foreign key (U_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table Similar add constraint FK_Similar foreign key (U_ID2)
      references User (U_ID) on delete restrict on update restrict;

alter table Similar add constraint FK_Similar2 foreign key (U_ID1)
      references User (U_ID) on delete restrict on update restrict;


delimiter $$
create function getIntersetQuesAmt (U_ID1 INT, U_ID2 INT) 
RETURNS INT

BEGIN
DECLARE quesAmt INT;

SELECT COUNT(*) AS amt INTO quesAmt
FROM Answer
WHERE Q_ID IN(
    SELECT Q_ID FROM Answer
    WHERE U_ID = U_ID1
) AND U_ID = U_ID2;

RETURN (quesAmt);
END
$$

delimiter ;


delimiter $$
create procedure getMostSimilar (IN vU_ID INT, IN voffset INT, IN vsize INT)
BEGIN
set @offset = voffset;
set @size = vsize;
set @uid = vU_ID;

prepare SimilarStmt from
"SELECT U_ID, getSimilarity(U_ID, ?) AS similar FROM Answer WHERE U_ID != ? GROUP BY U_ID ORDER BY similar DESC LIMIT ?, ?";

execute SimilarStmt using @uid, @uid, @offset, @size;
deallocate prepare SimilarStmt;
END
$$

delimiter ;


delimiter $$
create function getSimilarity (U_ID1 INT, U_ID2 INT) 
RETURNS FLOAT

BEGIN
DECLARE common INT;
DECLARE same INT;
DECLARE similarity FLOAT;

SELECT getIntersetQuesAmt(U_ID1, U_ID2) INTO common;
IF common = 0 THEN 
    SET similarity = 0;
ELSE
    SELECT COUNT(*) INTO same
    FROM Answer as ans1, Answer as ans2
    WHERE ans1.U_ID = U_ID1 AND ans2.U_ID = U_ID2
        AND ans1.Q_ID = ans2.Q_ID
        AND ans1.answer = ans2.answer;
    SET similarity = same / common;
END IF;

RETURN (similarity);
END
$$

delimiter ;


delimiter $$
create function getUnionQuesAmt (U_ID1 INT, U_ID2 INT) 
RETURNS INT

BEGIN
DECLARE quesAmt INT;

SELECT COUNT(DISTINCT Q_ID) AS amt INTO quesAmt
FROM Answer
WHERE U_ID = U_ID1 OR U_ID = U_ID2;

RETURN (quesAmt);
END
$$

delimiter ;


delimiter $$
create procedure insertSimilarProc (IN inU_ID INT, IN insertZero INT)
begin
insert into Similar(U_ID1, U_ID2, similarity)
SELECT inU_ID, U_ID, getSimilarity(inU_ID, U_ID) AS similar
FROM Answer 
WHERE inU_ID != U_ID AND (insertZero OR getSimilarity(inU_ID, U_ID) != 0)
GROUP BY U_ID;
end$$
delimiter ;


delimiter $$
create trigger similarInsertTrigger 
after insert on Answer
for each row
begin
call insertSimilarProc(new.U_ID, 0);
end$$
delimiter ;


delimiter $$
create trigger similarDeleteTrigger 
after delete on Answer
for each row
begin
call insertSimilarProc(old.U_ID, 1);
end$$
delimiter ;


delimiter $$
create trigger similarUpdateTrigger 
after update on Answer
for each row
begin
call insertSimilarProc(new.U_ID, 0);
call insertSimilarProc(old.U_ID, 1);
end$$
delimiter ;

