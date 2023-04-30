CREATE TABLE user_data(
  user_id int not null auto_increment primary key,
  email varchar(255) not null unique,
  username varchar(255) not null unique,
  fullname varchar(255) not null,
  profile_link varchar(255) default "/assets/image/profile/default.jpg",
  verified boolean default 0,
  created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  bio varchar(300),
  password varchar(500) not null,
  private boolean default 1,
  admin boolean default 0
  );

CREATE TABLE post(
  post_id int not null auto_increment primary key,
  post_img varchar(255),
  post_data varchar(255) not null,
  fk_user_id int references user_data(user_id)
  );

CREATE table likes(
  fk_user_id int references user_data(user_id),
  fk_post_id int references post(post_id)
  );

CREATE table comments(
  fk_user_id int references user_data(user_id),
  fk_post_id int references post(post_id),
  comment varchar(300)
  );

CREATE table follow(
  fk_user_id int references user_data(user_id),
  fk_other_user_id int references user_data(user_id),
  primary key(fk_user_id, fk_other_user_id)
  );

CREATE table interests(
  interest_id int not null primary key auto_increment,
  interest varchar(255)
  );

CREATE table user_interest(
  fk_user_id int references user_data(user_id),
  fk_interest_id int references interests(interest_id),
  primary key(fk_user_id, fk_interest_id)
  );

CREATE TABLE report(
  report_id int not null auto_increment primary key,
  fk_reported_by int references user_data(user_id),
  fk_post_id int references post(post_id)
);

CREATE TABLE verification_request(
  fk_user_id int not null primary key references user_data(user_id),
)