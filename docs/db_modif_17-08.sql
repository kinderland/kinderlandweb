-- Cria o campo que indica quanto tempo uma pessoa tem para pagar uma inscrição
ALTER TABLE summer_camp ADD COLUMN days_to_pay integer not null default 5;

-- Data limite para pagar a inscrição especifica. Pode ser alterada individualmente caso seja necessario
ALTER TABLE summer_camp_subscription ADD COLUMN date_payment_limit timestamp without time zone;