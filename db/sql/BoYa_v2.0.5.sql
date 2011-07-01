/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     6/24/2011 5:16:41 AM                         */
/*==============================================================*/


drop table if exists Answer;

drop table if exists Authority;

drop table if exists Follow;

drop table if exists Operate;

drop table if exists Own;

drop table if exists Question;

drop index nameIndex on User;

drop index emailIndex on User;

drop table if exists User;

/*==============================================================*/
/* Table: Answer                                                */
/*==============================================================*/
create table Answer
(
   U_ID                 char(10) not null,
   Q_ID                 char(10) not null,
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
   follower_ID          char(10) not null,
   following_ID         char(10) not null,
   follow_time          timestamp not null default CURRENT_TIMESTAMP,
   hasRead              bool not null,
   primary key (follower_ID, following_ID)
);

/*==============================================================*/
/* Table: Operate                                               */
/*==============================================================*/
create table Operate
(
   Q_ID                 char(10) not null,
   U_ID                 char(10) not null,
   operate_time         timestamp not null default CURRENT_TIMESTAMP,
   operate_type         char(1) not null,
   primary key (Q_ID, U_ID)
);

/*==============================================================*/
/* Table: Own                                                   */
/*==============================================================*/
create table Own
(
   U_ID                 char(10) not null,
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
   father_Q_ID          char(10),
   content              varchar(200) not null,
   Q_span               char(1),
   primary key (Q_ID)
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

