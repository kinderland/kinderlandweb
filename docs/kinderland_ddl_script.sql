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
    password character varying(50) NOT NULL,
    occupation character varying(40),
    user_type integer NOT NULL default 1 REFERENCES user_type
    
);
  
CREATE TABLE donation_type(
    donation_type integer PRIMARY KEY NOT NULL,
    description character varying(30) NOT NULL
);
  
CREATE TABLE donation_status(
    donation_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);
  
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
	date_start timestamp without time zone NOT NULL,
	date_finish timestamp without time zone NOT NULL,
	date_start_show timestamp without time zone NOT NULL,
	date_finish_show timestamp without time zone NOT NULL,
	private boolean NOT NULL default false,
	price decimal(9, 2) NOT NULL
);

CREATE TABLE subscription_status(
    subscription_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);
INSERT INTO subscription_status VALUES (1, ‘pre-inscrito’), (0, ‘pre-inscrito incompleto’), (2, ‘aguardando pagamento’), (3, ‘inscrito’), (-1, ‘cancelado’), (-2, ‘desistente’), (-3, ‘excluido’);

CREATE TABLE event_subscription (
	person_id integer NOT NULL REFERENCES person, -- id from the person that is going
	event_id integer NOT NULL REFERENCES event,
	person_user_id REFERENCES person_user (person_id), -- cpf from the user that is buying, may be or not the person who is going
	discount decimal(2, 2), --discount format: 0.6 = 60%
	final_price decimal(9, 2),
	subscription_status integer,
	donation_id integer REFERENCES donation,
	date_created timestamp without time zone DEFAULT current_timestamp,

	PRIMARY KEY (person_id, event_id)
);

CREATE TABLE payment_status(
    payment_status integer PRIMARY KEY NOT NULL,
    description character varying(30)
);

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
                AND private = false);