-- Cria o campo que indica quanto tempo uma pessoa tem para pagar uma inscrição
ALTER TABLE summer_camp ADD COLUMN days_to_pay integer not null default 5;

-- Data limite para pagar a inscrição especifica. Pode ser alterada individualmente caso seja necessario
ALTER TABLE summer_camp_subscription ADD COLUMN date_payment_limit timestamp without time zone;


CREATE OR REPLACE FUNCTION set_colonist_subscription_waiting_payment(_colonist_id integer, _summer_camp_id integer)
  RETURNS boolean AS
$BODY$
DECLARE
	cSql VARCHAR;
	iDaysToPay INTEGER;
	tsDateLimit TIMESTAMP WITHOUT TIME ZONE;
	iActSituation INTEGER;
	
BEGIN
	SELECT situation into iActSituation
	FROM summer_camp_subscription 
	WHERE summer_camp_id = _summer_camp_id 
	AND colonist_id = _colonist_id;

	IF (iActSituation <> 3) THEN
		RAISE NOTICE 'Camper status is not in queue';
		RETURN FALSE;
	END IF;

	SELECT days_to_pay INTO iDaysToPay 
	FROM summer_camp 
	WHERE summer_camp_id = _summer_camp_id; 

	RAISE NOTICE 'Days to pay: %', iDaysToPay;

	tsDateLimit := (current_timestamp + ( iDaysToPay || ' days')::interval)::date || ' 23:59:59';
	RAISE NOTICE 'Date Limit: %', tsDateLimit;
	
	UPDATE summer_camp_subscription 
	SET date_payment_limit = tsDateLimit,
	    situation = 4
	WHERE summer_camp_id = _summer_camp_id 
	AND colonist_id = _colonist_id;

	RETURN TRUE;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;