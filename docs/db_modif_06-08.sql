-- adicionar tipo de doação inscrição de colonista

INSERT INTO donation_type VALUES (4, 'inscrição colonia', 0.00);

-- adicionar coluna de desconto

ALTER TABLE summer_camp_subscription ADD COLUMN discount integer not null default '0';
ALTER TABLE summer_camp_subscription ADD CONSTRAINT discount_check CHECK (discount >= 0 and discount <= 100);

-- adicionar preço especial para sócios na tabela.

ALTER TABLE summer_camp_payment_period ADD COLUMN associate_price numeric(9,2) NOT NULL;

