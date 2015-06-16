--Use these lines to drop all tables
--DROP SCHEMA public CASCADE;
--CREATE SCHEMA public;


CREATE TABLE user_type (
    user_type integer PRIMARY KEY,
    description character varying(50) NOT NULL
);
INSERT INTO user_type VALUES 
(1, 'common user'), 
(2, 'system admin'), 
(3, 'director'), 
(4, 'secretary'), 
(5, 'coordinator'),
(6, 'doctor'),
(7, 'monitor-instructor');

CREATE TABLE address (
    address_id serial PRIMARY KEY,
    street character varying(100) NOT NULL,
    place_number integer,
    complement character varying(255),
    city character varying(40),
    cep character varying(9),
    uf character varying(2),
    neighborhood character varying(80)
);

CREATE TABLE age_group (
    age_group_id INTEGER NOT NULL PRIMARY KEY,
    description VARCHAR NOT NULL
);
INSERT INTO age_group VALUES (1, '0-5 anos'), (2, '6-17 anos'), (3, '+18 anos');
  
CREATE TABLE person (
    person_id serial PRIMARY KEY,
    fullname character varying(80) NOT NULL,
    date_created timestamp without time zone default current_timestamp,
    date_updated timestamp without time zone,
    gender character(1),
    email character varying(120),
    address_id integer REFERENCES address,
    CHECK (gender = 'M' OR gender = 'F')
);
  
CREATE TABLE telephone (
    phone_number character varying(25) NOT NULL,
    person_id integer REFERENCES person,
    PRIMARY KEY (phone_number, person_id)
);
  
CREATE TABLE person_user (
    person_id integer REFERENCES person PRIMARY KEY,
    cpf character varying(20) UNIQUE,
    login character varying(120) UNIQUE NOT NULL,
    password character varying(300) NOT NULL,
    occupation character varying(40)
);

CREATE TABLE person_user_type
(
  person_id integer NOT NULL,
  user_type integer NOT NULL,
  CONSTRAINT pk_person_user_type PRIMARY KEY (person_id, user_type),
  CONSTRAINT fk_person FOREIGN KEY (person_id)
      REFERENCES person_user (person_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_user_type FOREIGN KEY (user_type)
      REFERENCES user_type (user_type) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);
  
CREATE TABLE donation_type(
    donation_type integer PRIMARY KEY NOT NULL,
    description character varying(30) NOT NULL,
    minimum_price numeric(7,2) DEFAULT 0.0
);
INSERT INTO donation_type VALUES (1, 'avulsa', 20.00), (2, 'associação', 720.00), (3, 'inscrição', 0.00);
  
CREATE TABLE donation_status(
    donation_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);
INSERT INTO donation_status VALUES (1, 'aberto'), (2, 'pago'),(-1, 'abandonado'), (3, 'não autorizado');
  
CREATE TABLE donation (
    donation_id serial PRIMARY KEY,
    person_id integer REFERENCES person,
    donation_type integer REFERENCES donation_type,
    date_created timestamp without time zone default current_timestamp,
    date_updated timestamp without time zone,
    donated_value decimal(7, 2) NOT NULL,
    donation_status integer REFERENCES donation_status
);

CREATE TABLE event (
    event_id serial PRIMARY KEY,
    event_name character varying(255) NOT NULL,
    description character varying(500),
    date_created timestamp without time zone DEFAULT current_timestamp,
    date_start timestamp without time zone,
    date_finish timestamp without time zone,
    date_start_show timestamp without time zone,
    date_finish_show timestamp without time zone,
    enabled boolean NOT NULL default false,
    capacity_male integer NOT NULL DEFAULT 0,
    capacity_female integer NOT NULL DEFAULT 0,
    capacity_nonsleeper integer NOT NULL DEFAULT 0
);

CREATE TABLE communication (
    communication_id serial PRIMARY KEY NOT NULL,
    content text NOT NULL,
    date_sent timestamp without time zone DEFAULT now() NOT NULL,
    type character varying(10) NOT NULL,
    successfully_sent boolean NOT NULL
);


CREATE TABLE communication_recipient (
    communication_id integer NOT NULL,
    recipient character varying(200) NOT NULL,
    recipient_type character varying(20) NOT NULL,
    PRIMARY KEY (communication_id, recipient, recipient_type),
    FOREIGN KEY (communication_id) REFERENCES communication(communication_id)
);


CREATE TABLE subscription_status(
    subscription_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);
INSERT INTO subscription_status VALUES (1, 'pre-inscrito'), (0, 'pre-inscrito incompleto'), (2, 'aguardando pagamento'), (3, 'inscrito'), (-1, 'cancelado'), (-2, 'desistente'), (-3, 'excluido');

CREATE TABLE payment_period (
    payment_period_id SERIAL,
    event_id INTEGER NOT NULL REFERENCES event,
    date_start TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    date_finish TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    full_price decimal(9,2) NOT NULL,
    children_price decimal(9,2) NOT NULL,
    middle_price numeric(9,2) NOT NULL,
    associate_discount decimal(3,2) NOT NULL DEFAULT 0.0,
    portions integer NOT NULL DEFAULT 1,

    PRIMARY KEY(payment_period_id)
);

CREATE TABLE event_subscription (
    person_id integer NOT NULL REFERENCES person, -- id from the person that is going
    event_id integer NOT NULL REFERENCES event,
    person_user_id integer NOT NULL,
    subscription_status integer REFERENCES subscription_status,
    donation_id integer REFERENCES donation,
    date_created timestamp without time zone DEFAULT now(),
    age_group_id integer NOT NULL REFERENCES age_group DEFAULT 3,
    associate boolean default false,
    nonsleeper boolean default false,

    PRIMARY KEY (person_id, event_id),
    CONSTRAINT fk_person_user_event FOREIGN KEY (person_user_id)
      REFERENCES person_user (person_id)
);

CREATE TABLE payment_status(
    payment_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);

INSERT INTO payment_status VALUES
(0,'Transação Criada'),
(1,'Transação em Andamento'),
(2,'Transação Autenticada'),
(3,'Transação não Autenticada'),
(4,'Transação Autorizada'),
(5,'Transação não Autorizada'),
(6,'Transação Capturada'),
(9,'Transação Cancelada'),
(10,'Transação em Autenticação'),
(12,'Transação em Cancelamento');


CREATE TABLE cielo_transaction (
    tid character varying(50) PRIMARY KEY,
    payment_type character varying(20), -- debito/credito
    cardflag character varying(20), -- amex/visa/mastercard
    payment_portions integer NOT NULL DEFAULT 1,
    donation_id integer REFERENCES donation,
    payment_status integer REFERENCES payment_status,
    date_created timestamp without time zone DEFAULT current_timestamp,
    date_updated timestamp without time zone,
    transaction_value decimal(9,2)
);

CREATE TABLE benemerits (
    person_id integer not null REFERENCES person PRIMARY KEY,
    date_started timestamp without time zone default current_timestamp,
    date_finished timestamp without time zone
);

CREATE TABLE school (
    school_name varchar(70) NOT NULL PRIMARY KEY
);

CREATE TABLE summer_camp (
    summer_camp_id SERIAL PRIMARY KEY NOT NULL,
    camp_name varchar (150) not null,
    description varchar(500),
    date_created timestamp without time zone DEFAULT now(),
    date_start timestamp without time zone,
    date_finish timestamp without time zone,
    date_start_pre_subscriptions timestamp without time zone,
    date_finish_pre_subscriptions timestamp without time zone,
    date_start_pre_subscriptions_associate timestamp without time zone,
    date_finish_pre_subscriptions_associate timestamp without time zone,
    pre_subscriptions_enabled boolean default false,
    capacity_male integer not null default 0,
    capacity_female integer not null default 0
);

CREATE TABLE colonist (
    colonist_id SERIAL NOT NULL PRIMARY KEY,
    person_id INTEGER NOT NULL REFERENCES person,
    birth_date timestamp without time zone NOT NULL,
    date_created timestamp without time zone default now(),
    document_number varchar(100),
    document_type varchar(25),
    emergency_phonenumber varchar(30)
);

CREATE TABLE summer_camp_subscription_status (
    status integer not null PRIMARY KEY,
    description varchar(50)
);
INSERT INTO summer_camp_subscription_status VALUES
(0, 'pre-inscricao em elaboracao'), 
(1, 'pre-inscricao aguardando validação'), 
(2, 'pre-inscrição validada'),
(3, 'pre-inscricao na fila de espera'), 
(4, 'pre-inscricao aguardando pagamento'), 
(5, 'inscrito'), 
(-1, 'desistente'), 
(-2, 'excluido'),
(-3, 'cancelado');


CREATE TABLE summer_camp_subscription (
    summer_camp_id INTEGER NOT NULL REFERENCES summer_camp,
    colonist_id INTEGER NOT NULL REFERENCES colonist,
    person_user_id INTEGER NOT NULL REFERENCES person_user(person_id),
    situation INTEGER NOT NULL REFERENCES summer_camp_subscription_status(status),
    donation_id integer REFERENCES donation,
    date_created timestamp without time zone,
    school_name varchar(70),
    school_year integer not null,
    accepted_terms boolean default false,
    accepted_travel_terms boolean default false
);

ALTER TABLE ONLY summer_camp_subscription
    ADD CONSTRAINT summer_camp_subscription_pkey PRIMARY KEY (summer_camp_id, colonist_id);



CREATE TABLE camp_payment_period (
    camp_payment_period_id SERIAL,
    summer_camp_id INTEGER NOT NULL REFERENCES event,
    date_start TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    date_finish TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    portions integer NOT NULL DEFAULT 1,

    PRIMARY KEY(camp_payment_period_id)
);

CREATE TABLE document_type (
    document_type SERIAL NOT NULL PRIMARY KEY,
    description character varying(100)
);

INSERT INTO document_type VALUES
(1, 'teste');


CREATE TABLE document (
    document_id SERIAL NOT NULL PRIMARY KEY,
    summer_camp_id integer,
    colonist_id integer,
    date_created timestamp without time zone DEFAULT now(),
    filename character varying(100) NOT NULL,
    extension character varying(100) NOT NULL,
    document_type integer NOT NULL,
    file bytea NOT NULL,
    user_id integer NOT NULL
);

ALTER TABLE ONLY document
    ADD CONSTRAINT "UK_document" UNIQUE (summer_camp_id, colonist_id, date_created);

ALTER TABLE ONLY document
    ADD CONSTRAINT document_summer_camp_id_fkey FOREIGN KEY (summer_camp_id, colonist_id) REFERENCES summer_camp_subscription(summer_camp_id, colonist_id);

ALTER TABLE ONLY document
    ADD CONSTRAINT document_user_id_fkey FOREIGN KEY (user_id) REFERENCES person_user(person_id);

CREATE TABLE parent_summer_camp_subscription (
    summer_camp_id integer NOT NULL,
    colonist_id integer NOT NULL,
    parent_id integer NOT NULL,
    relation character varying(10)
);

ALTER TABLE ONLY parent_summer_camp_subscription
    ADD CONSTRAINT parent_summer_camp_subscription_pkey PRIMARY KEY (summer_camp_id, colonist_id, parent_id);

ALTER TABLE ONLY parent_summer_camp_subscription
    ADD CONSTRAINT "FK_parent_summer_camp_subscription_person" FOREIGN KEY (parent_id) REFERENCES person(person_id);

CREATE VIEW open_public_events as (SELECT * FROM event 
                WHERE current_timestamp BETWEEN date_start_show AND date_finish_show 
                AND enabled = true);

CREATE VIEW associates AS (
  SELECT pu.person_id,
    pu.cpf,
    pu.login,
    pu.occupation
   FROM person_user pu
     JOIN donation d ON d.person_id = pu.person_id
  WHERE d.donation_type = 2 AND date_part('year'::text, d.date_created) = date_part('year'::text, now()) AND d.donation_status = 2
  UNION 
  SELECT pu.person_id,
    pu.cpf,
    pu.login,
    pu.occupation
   FROM person_user pu
  INNER JOIN benemerits b on b.person_id = pu.person_id
  WHERE b.date_finished is null
);

CREATE VIEW donations_completed AS (
    SELECT *
    FROM donation
    WHERE
        donation_status = 2
);

CREATE VIEW donation_detailed AS (
    SELECT
        d.donation_id,
        d.person_id,
        dt.description as donation_type,
        ds.description as donation_status,
        d.date_created,
        d.donated_value
    FROM
        donation d
    INNER JOIN
        donation_type dt
    ON dt.donation_type = d.donation_type
    INNER JOIN
        donation_status ds
    ON ds.donation_status = d.donation_status
    
);

CREATE TABLE system_method
(
  system_method_id serial NOT NULL,
  method_name character varying(50) NOT NULL,
  controller_name character varying(20),
  user_type integer NOT NULL,
  date_inserted timestamp without time zone DEFAULT now(),
  CONSTRAINT pk_system_methods PRIMARY KEY (system_method_id)
);

----------------------------------- Views Section -----------------------------------

CREATE OR REPLACE VIEW donations_pending AS (
    SELECT 
        *
    FROM donation
    WHERE donation_status = 1 
    AND (current_timestamp - donation.date_created) > '1 hour'::interval
);

CREATE OR REPLACE VIEW v_report_user_registered AS 
 SELECT count_users.count_users,
    count_associates.count_associates,
    count_benemerit.count_benemerit,
    count_non_benemerit.count_non_associate
   FROM ( SELECT count(*) AS count_users
           FROM person_user) count_users,
    ( SELECT count(*) AS count_associates
           FROM associates) count_associates,
    ( SELECT count(*) AS count_benemerit
           FROM benemerits b
          WHERE date_finished is null) count_benemerit,
    ( SELECT count(*) AS count_non_associate
           FROM person_user
          WHERE NOT (person_user.person_id IN ( SELECT associates.person_id
                   FROM associates))) count_non_benemerit;

-- Essa view ainda precisa ser aprimorada para exibir que tipo de sócio a pessoa é
CREATE VIEW v_report_all_users AS (
    SELECT 
        p.fullname, p.email, COALESCE((SELECT true from associates where person_id = p.person_id), false) as associate, p.person_id
    FROM
        person p 
    INNER JOIN 
        person_user pu on p.person_id = pu.person_id
);

CREATE VIEW v_report_all_users_association_detailed AS (
    SELECT * FROM (
        SELECT p.fullname,
            p.email,
            'não sócio' as associate,
            p.person_id
        FROM
            person_user pu
        INNER JOIN
            person p on pu.person_id = p.person_id
        WHERE
            pu.person_id not in( SELECT person_id FROM associates )
        UNION
        SELECT p.fullname,
            p.email,
            'contribuinte' AS associate,
            p.person_id
        FROM associates a
        INNER JOIN
            person p ON p.person_id = a.person_id
        WHERE
            a.person_id not in (
                SELECT
                    p.person_id
                FROM
                    benemerits b
                INNER JOIN
                    person p on p.person_id = b.person_id
                WHERE
                    b.date_finished is null
            )
        UNION
        SELECT p.fullname,
            p.email,
            'benemerito' AS associate,
            p.person_id
        FROM
            benemerits b
        INNER JOIN
            person p on p.person_id = b.person_id
        WHERE
            b.date_finished is null
    ) as A
    ORDER BY A.fullname
);

CREATE OR REPLACE VIEW v_rel_associated_campaign AS (
    SELECT vall.fullname,
        vall.email,
        vall.associate,
        vall.person_id,
        CASE
            WHEN vall.associate = 'contribuinte'::text THEN ( SELECT donation.date_created
               FROM donation
              WHERE donation.person_id = vall.person_id AND donation.donation_status = 2 AND donation.donation_type = 2)
            WHEN vall.associate = 'benemerito'::text THEN ( SELECT benemerits.date_started
               FROM benemerits
              WHERE benemerits.person_id = vall.person_id AND benemerits.date_finished IS NULL)
            ELSE NULL::timestamp without time zone
        END AS data_associacao
    FROM v_report_all_users_association_detailed vall
    WHERE vall.associate = 'contribuinte'::text
);

CREATE OR REPLACE VIEW v_report_free_donations AS 
 SELECT c.date_created,
    p.person_id,
    p.fullname,
    p.associate,
    d.donated_value,
    c.payment_type,
    c.cardflag,
    c.payment_portions,
    d.donation_type
   FROM donation d
     JOIN v_report_all_users_association_detailed p ON d.person_id = p.person_id
     JOIN cielo_transaction c ON c.donation_id = d.donation_id
  WHERE c.payment_status = 6;
 
 CREATE OR REPLACE VIEW v_users_permissions AS 
 SELECT DISTINCT p.person_id,
    p.fullname,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 1), 0) AS common_user,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 2), 0) AS system_admin,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 3), 0) AS director,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 4), 0) AS secretary,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 5), 0) AS coordinator,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 6), 0) AS doctor,
    COALESCE(( SELECT 1
           FROM person_user_type
          WHERE person_user_type.person_id = p.person_id AND person_user_type.user_type = 7), 0) AS monitor_instructor
   FROM person_user_type put
     LEFT JOIN person p ON p.person_id = put.person_id
  ORDER BY p.fullname;
