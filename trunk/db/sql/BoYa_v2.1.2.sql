/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     7/3/2011 3:06:38 PM                          */
/*==============================================================*/

/*
drop trigger similarTrigger;

drop trigger birthdayTrigger;
*/

drop function if exists getCommonQuesAmt;

drop procedure if exists getMostSimilar;

drop function if exists getSimilarity;

drop procedure if exists insertQuesProc;

drop procedure if exists insertSimilarProc;

drop table if exists Answer;

drop table if exists Authority;

drop table if exists Follow;

drop table if exists Operate;

drop table if exists Own;

drop table if exists Question;

drop table if exists Similar;

drop index nameIndex on User;

drop index emailIndex on User;

drop table if exists User;

/*==============================================================*/
/* Table: Answer                                                */
/*==============================================================*/
create table Answer
(
   U_ID                 int not null,
   Q_ID                 int not null,
   answer_time          timestamp not null default CURRENT_TIMESTAMP,
   answer               bool not null,
   primary key (U_ID, Q_ID)
);

/*==============================================================*/
/* Table: Authority                                             */
/*==============================================================*/
create table Authority
(
   authority_name       char(32) not null,
   add_user             bool,
   delete_user          bool,
   modify_user          bool,
   query_user           bool,
   add_question         bool,
   delete_question      bool,
   modify_qustion       bool,
   query_question       bool,
   primary key (authority_name)
);

/*==============================================================*/
/* Table: Follow                                                */
/*==============================================================*/
create table Follow
(
   follower_ID          int not null,
   following_ID         int not null,
   follow_time          timestamp not null default CURRENT_TIMESTAMP,
   hasRead              bool not null,
   primary key (follower_ID, following_ID)
);

/*==============================================================*/
/* Table: Operate                                               */
/*==============================================================*/
create table Operate
(
   Q_ID                 int not null,
   U_ID                 int not null,
   operate_time         timestamp not null default CURRENT_TIMESTAMP,
   operate_type         char(1) not null,
   primary key (Q_ID, U_ID)
);

/*==============================================================*/
/* Table: Own                                                   */
/*==============================================================*/
create table Own
(
   U_ID                 int not null,
   authority_name       char(32) not null,
   modify_time          timestamp not null default CURRENT_TIMESTAMP,
   primary key (U_ID, authority_name)
);

/*==============================================================*/
/* Table: Question                                              */
/*==============================================================*/
create table Question
(
   Q_ID                 int not null auto_increment,
   father_Q_ID          int,
   content              varchar(200) not null,
   Q_span               char(1),
   primary key (Q_ID)
);

/*==============================================================*/
/* Table: Similar                                               */
/*==============================================================*/
create table Similar
(
   U_ID1                int not null,
   U_ID2                int not null,
   similarity           float not null,
   update_time          timestamp not null default CURRENT_TIMESTAMP,
   primary key (U_ID1, U_ID2, update_time)
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
   gender               bool,
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

alter table Operate add constraint FK_Operated foreign key (Q_ID)
      references Question (Q_ID) on delete restrict on update restrict;

alter table Operate add constraint FK_Operates foreign key (U_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table Own add constraint FK_Owned foreign key (authority_name)
      references Authority (authority_name) on delete restrict on update restrict;

alter table Own add constraint FK_Owns foreign key (U_ID)
      references User (U_ID) on delete restrict on update restrict;

alter table Question add constraint FK_Specifies foreign key (father_Q_ID)
      references Question (Q_ID) on delete restrict on update restrict;

alter table Similar add constraint FK_Similar foreign key (U_ID2)
      references User (U_ID) on delete restrict on update restrict;

alter table Similar add constraint FK_Similar2 foreign key (U_ID1)
      references User (U_ID) on delete restrict on update restrict;


delimiter $$
create function getCommonQuesAmt (U_ID1 INT, U_ID2 INT) 
RETURNS INT

BEGIN
DECLARE quesAmt INT;

SELECT COUNT(*) INTO quesAmt
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
"SELECT U_ID, getSimilarity(U_ID, ?) AS similar FROM Answer GROUP BY U_ID ORDER BY similar DESC LIMIT ?, ?";

execute SimilarStmt using @uid, @offset, @size;
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

SELECT getCommonQuesAmt(U_ID1, U_ID2) INTO common;
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

/*
create procedure insertQuesProc (IN Q_ID INT);
*/

delimiter $$
create procedure insertSimilarProc (IN inU_ID INT)
begin
insert into Similar(U_ID1, U_ID2, similarity)
SELECT inU_ID, U_ID, getSimilarity(inU_ID, U_ID) AS similar
FROM Answer 
WHERE inU_ID != U_ID AND getSimilarity(inU_ID, U_ID) != 0
GROUP BY U_ID;
end$$
delimiter ;


delimiter $$
create trigger similarTrigger 
after insert on Answer
for each row
begin
call insertSimilarProc(new.U_ID);
end$$
delimiter ;

