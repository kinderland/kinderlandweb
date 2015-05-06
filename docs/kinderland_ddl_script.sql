--Use these lines to drop all tables
--DROP SCHEMA public CASCADE;
--CREATE SCHEMA public;


CREATE TABLE user_type (
    user_type integer PRIMARY KEY,
    description character varying(50) NOT NULL
);
INSERT INTO user_type VALUES (1, 'common user'), (2, 'system admin'), (3, 'director'), (4, 'secretary'), (5, 'coordinator');

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
    benemerit boolean default false,
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
INSERT INTO donation_type VALUES (1, 'avulsa', 20.00), (2, 'associacao', 660.00), (3, 'inscricao', 0.00);
  
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
  INNER JOIN person p on p.person_id = pu.person_id
  WHERE p.benemerit = true
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
           FROM associates
             JOIN person ON associates.person_id = person.person_id AND person.benemerit = false) count_associates,
    ( SELECT count(*) AS count_benemerit
           FROM associates
             JOIN person ON associates.person_id = person.person_id AND person.benemerit = true) count_benemerit,
    ( SELECT count(*) AS count_non_associate
           FROM person_user
          WHERE NOT (person_user.person_id IN ( SELECT associates.person_id
                   FROM associates))) count_non_benemerit;

-- Essa view ainda precisa ser aprimorada para exibir que tipo de sócio a pessoa é
CREATE VIEW v_report_all_users AS (
    SELECT 
        p.fullname, p.email, COALESCE((SELECT true from associates where person_id = p.person_id), false) as associate
    FROM
        person p 
    INNER JOIN 
        person_user pu on p.person_id = pu.person_id
);
