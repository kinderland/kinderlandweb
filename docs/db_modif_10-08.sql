-- criar tabela de razões de desconto

create table discount_reason(
discount_reason_id SERIAL PRIMARY KEY,
discount_reason CHARACTER VARYING(200) UNIQUE NOT NULL
);

INSERT INTO discount_reason VALUES (1, 'Desconto igual ao da escola');
INSERT INTO discount_reason VALUES (2, 'Segundo irmão');
INSERT INTO discount_reason VALUES (3, 'Terceiro irmão');
INSERT INTO discount_reason VALUES (4, 'Lar da criança');

-- adicionar colunas de razão de desconto

ALTER TABLE summer_camp_subscription ADD COLUMN discount_reason_id integer;
ALTER TABLE summer_camp_subscription ADD CONSTRAINT discount_reason_FK FOREIGN KEY (discount_reason_id) REFERENCES discount_reason(discount_reason_id) ON DELETE RESTRICT;

-- adicionar controladores na tabela de methodos

INSERT INTO system_method (method_name,controller_name,user_type) VALUES ('setDiscount', 'admin', 2);
INSERT INTO system_method (method_name,controller_name,user_type) VALUES ('setDiscountValue', 'admin', 2);


-- view para pegar os colonistas com número de fila de espera

CREATE OR REPLACE VIEW v_colonists_with_queue_number as (
	select scs.summer_camp_id, scs.colonist_id, scs.person_user_id,
	pr.fullname as responsible_name, p.fullname as colonist_name,
	description, queue_number, p.person_id AS colonist_person_id
	from summer_camp_subscription scs
	inner join summer_camp_subscription_status s on s.status = scs.situation
	inner join colonist c on c.colonist_id = scs.colonist_id
	inner join person p on p.person_id = c.person_id
	inner join person pr on pr.person_id = scs.person_user_id
	where queue_number is not null
	order by queue_number
);
