-- Function: importacaoleads(integer, integer)

-- DROP FUNCTION importacaoleads(integer, integer);

CREATE OR REPLACE FUNCTION importacaoleads(integer, integer)
  RETURNS character varying AS
$BODY$DECLARE
--
	pIdUser				ALIAS FOR $1;
	pIdOrigen			ALIAS FOR $2;
--
	vIdCliente			public.clientes.id%TYPE;
	vIdImportacaoLead	public.importacaoleads.id%TYPE;
	vCont				public.clientes.id%TYPE;
--
	rCursor				RECORD;
--
BEGIN
	--
	DROP TABLE IF EXISTS clientes_tmp;
	--
	INSERT INTO public.importacaoleads(created,
									   origen_id,
									   user_id)
							    values(now(),
							    	  pIdOrigen,
							    	  pIdUser);
	--
	SELECT MAX(id)
	  INTO vIdImportacaoLead
	  FROM public.importacaoleads;						    	  
	--
	CREATE TEMPORARY TABLE clientes_tmp(email varchar(250) NULL,
										nome varchar(100) NULL,
										telefone varchar(100) NULL);
	--
	COPY clientes_tmp from 'http://www.imobiliariaeduardolang.com.br/gestao/webroot/arquivos/leads.csv' using delimiters ',' CSV HEADER;
	--
	FOR rCursor IN SELECT replace(clientes_tmp.nome, '"', '') as nome,
						  clientes_tmp.email,
						  replace(clientes_tmp.telefone, 'p:+', '') as telefone
				 	 FROM clientes_tmp LOOP
		--
		INSERT INTO public.clientes(nome,
									email,
									telefone)
							 VALUES(rCursor.nome,
							 		rCursor.email,
									rCursor.telefone);		
		--
		SELECT MAX(id)
		  INTO vIdCliente
		  FROM public.clientes;
		--
		INSERT INTO public.leads(cliente_id,
								 status,
								 importacaolead_id)
						  values(vIdCliente,
						  		 'A',
						  		 vIdImportacaoLead);
		--
	END LOOP;
	--
	RETURN 'OK';
	--
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION importacaoleads(integer, integer)
  OWNER TO postgres;
