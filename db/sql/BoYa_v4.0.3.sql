/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     7/11/2011 9:08:33 PM                         */
/*==============================================================*/



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
/* Index: answerTimeIndex                                       */
/*==============================================================*/
create index answerTimeIndex on Answer
(
   answer_time
);

/*==============================================================*/
/* Table: Follow                                                */
/*==============================================================*/
create table Follow
(
   follower_ID          int not null,
   following_ID         int not null,
   follow_time          timestamp not null default CURRENT_TIMESTAMP,
   primary key (follower_ID, following_ID)
);

/*==============================================================*/
/* Index: followTimeIndex                                       */
/*==============================================================*/
create index followTimeIndex on Follow
(
   follow_time
);

/*==============================================================*/
/* Table: Question                                              */
/*==============================================================*/
create table Question
(
   Q_ID                 int not null auto_increment,
   content              varchar(200) not null,
   Q_spam               char(1) not null,
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
/* Index: similarTimeInedx                                      */
/*==============================================================*/
create index similarTimeInedx on Similar
(
   update_time
);

/*==============================================================*/
/* Index: similarIndex                                          */
/*==============================================================*/
create index similarIndex on Similar
(
   similarity
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
   VIP                  bool not null,
   U_spam               char(1) not null,
   primary key (U_ID)
);

alter table Answer add constraint FK_Answered foreign key (Q_ID)
      references Question (Q_ID) on delete cascade on update cascade;

alter table Answer add constraint FK_Answers foreign key (U_ID)
      references User (U_ID) on delete cascade on update cascade;

alter table Follow add constraint FK_Followed foreign key (following_ID)
      references User (U_ID) on delete cascade on update cascade;

alter table Follow add constraint FK_Follows foreign key (follower_ID)
      references User (U_ID) on delete cascade on update cascade;

alter table Similar add constraint FK_Similar foreign key (U_ID2)
      references User (U_ID) on delete cascade on update cascade;

alter table Similar add constraint FK_Similar2 foreign key (U_ID1)
      references User (U_ID) on delete cascade on update cascade;



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
