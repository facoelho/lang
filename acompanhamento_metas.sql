-- Function: estoque.gera_posicao_estoque(integer)

-- DROP FUNCTION estoque.gera_posicao_estoque(integer);

CREATE OR REPLACE FUNCTION estoque.gera_posicao_estoque(integer)
  RETURNS character varying AS
$BODY$DECLARE
--
	pPedido_id      ALIAS FOR $1;
--
	vCount					estoque.pedidos.id%TYPE;
	vEstoque_Item_id		estoque.estoques_itens_historicos.estoque_item_id%TYPE;
	vQdtPedida				estoque.estoques_itens_historicos.quantidade%TYPE;
	vQuantidade				estoque.estoques_itens_historicos.quantidade%TYPE;
	vQtdEstoque				estoque.estoques_itens.quantidade%TYPE;
	vReservado				estoque.estoques_itens.reservado%TYPE;
	vData					estoque.pedidos.dt_criado%TYPE;
--
	rCursor  				RECORD;
--
BEGIN
	--
	SELECT count(*)
	  INTO vCount
	  FROM estoque.posicaos_estoques
	 WHERE pedido_id = pPedido_id;
	--
	IF vCount > 0 THEN
		--
		DELETE 
	   	  FROM estoque.posicaos_estoques
	  	 WHERE pedido_id = pPedido_id;
		--
	END IF;
	--
	FOR rCursor IN SELECT estoque_item_id, max(estoques_itens_historicos.id) as id
				     FROM estoques_itens_historicos
					WHERE pedido_id = pPedido_id
					  AND estoques_itens_historicos.quantidade > 0
					GROUP BY estoque_item_id LOOP
		--
		SELECT pedidos.dt_criado,
			   estoques_itens_historicos.quantidade as qtd_pedida,
			   estoques_itens.id,
			   estoques_itens.quantidade,
			   estoques_itens.reservado
		  INTO vData,
		  	   vQdtPedida,
		  	   vEstoque_Item_id,
		  	   vQtdEstoque,
		  	   vReservado
		  FROM estoque.pedidos,
			   estoque.estoques_itens,
			   estoque.estoques_itens_historicos
		 WHERE pedidos.id        			= estoques_itens_historicos.pedido_id
		   AND estoques_itens.id            = estoques_itens_historicos.estoque_item_id
		   AND estoques_itens_historicos.id = rCursor.id;
		--
		INSERT INTO estoque.posicaos_estoques(pedido_id,
											  estoque_item_id,
											  quantidade,
											  qtd_pedida,
											  reservado,
											  dt_criado)
									  VALUES (pPedido_id,
											  vEstoque_Item_id,
											  vQtdEstoque,
											  vQdtPedida,
											  vReservado,
											  vData);
		--
	END LOOP;
	--
	RETURN 'OK';
	--
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION estoque.gera_posicao_estoque(integer)
  OWNER TO postgres;