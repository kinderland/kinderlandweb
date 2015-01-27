CREATE TABLE address (
    address_id serial PRIMARY KEY,
    street character varying(100) NOT NULL,
    place_number integer,
    complement character varying(255),
    city character varying(40),
    cep character varying(9),
    uf character varying(2),
	neighborhood character varying(35)
);
 
CREATE TABLE person (
    person_id serial PRIMARY KEY,
    fullname character varying(80) NOT NULL,
    date_created timestamp without time zone,
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
    person_id integer REFERENCES person,
    cpf character varying(20) PRIMARY KEY,
    login character varying(20) UNIQUE NOT NULL,
    password character varying(50) NOT NULL,
    occupation character varying(40)
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
    date_created timestamp without time zone,
    date_updated timestamp without time zone,
    donated_value decimal(7, 2) NOT NULL,
    donation_status integer REFERENCES donation_status
);