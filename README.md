Integração do Magento com RD Station (Resultados Digitais)
=========================================================

Módulo de integração entre o magento e a plataforma RD Station da Resultados Digitais para criação e qualificação de leads.

Este módulo executa chamadas para a API do RDStation quando:

- Um formulário de contato é enviado
- Uma nova conta de cliente é criada
- Um novo pedido é criado
- Um cliente assina a newsletter da loja virtual
- Um item é adicionado ao carrinho de compras quando o cliente está logado
- Um pagamento recorrente de uma assinatura é processado - Os observers estão apenas aguardando os eventos serem disparados pela extensão que gerenciar as assinaturas.


Configuração
============

A configuração é extremamente simples, bastando habilitar o módulo e preencher o campo em Sistema -> Configuração -> Flow eCommerce -> Resultados Digitais -> Token com o seu token de integração.

O Token pode ser obtido no próprio RD Station, em Configurações -> Integração.

Changelog
---------
* 0.1.5
  * Bugfix - Quando um lead não havia sido ainda processado pelo RD a conversão em venda não estava sendo processada com sucesso (a conversão do lead leva alguns segundos). Adicionadas conversões para adição de produtos ao carrinho, bem como os observers para pagamentos recorrentes.

* 0.1.4
  * PR por Bruno Gianni https://github.com/gabrielqs/Flowecommerce_Resultadosdigitais/pull/4
  
* 0.1.3
  * Bugfix: marcar lead como cliente junto com a conversão order_sale não estava funcionando corretamente. Melhoria: enviando dados dos produtos (nomes, categorias, sku) junto com a conversão order_sale.

* 0.1.2
  * Merge do Pull Requeste por @thiesen. Marcando uma venda no RD após uma nova venda ser efetuada no magento

* 0.1.0
  * Versão inicial do módulo - conversões em vendas, assinatura de newsletter, cadastro de nova conta e formulário de contato