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

