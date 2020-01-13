CREATE OR REPLACE FUNCTION public.importacao_imoveis()
  RETURNS character varying AS
$BODY$DECLARE
--
BEGIN
	--
	COPY clientes from 'C:\xampp\htdocs\lang\app\webroot\arquivos\imoveis.csv' using delimiters ',' CSV HEADER;
	--	
	RETURN 'OK';
	--
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.importacao_imoveis()
  OWNER TO postgres;