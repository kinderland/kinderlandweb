--Correção bug da tarefa 929

SELECT pg_catalog.setval('discount_reason_discount_reason_id_seq', 6, true);

--Modificar Pré-inscrição aguardando pagamento para Pré-inscrição aguardando doação

Update summer_camp_subscription_status set description = 'Pré-inscrição aguardando doação' where description = 'Pré-inscrição aguardando pagamento'

INSERT INTO system_method (method_name,controller_name,user_type) VALUES ('donateMultipleColonists', 'summercamps', 1);
