Integração do Magento com RD Station (Resultados Digitais)
=========================================================

Módulo de integração entre o magento e a plataforma RD Station da Resultados Digitais para criação e qualificação de leads.

Este módulo executa chamadas para a API do RDStation quando:

- Um formulário de contato é enviado
- Uma nova conta de cliente é criada
- Um novo pedido é criado
- Um cliente assina a newsletter da loja virtual


Configuração
============

A configuração é extremamente simples, bastando habilitar o módulo e preencher o campo em Sistema -> Configuração -> Flow eCommerce -> Resultados Digitais -> Token com o seu token de integração.

O Token pode ser obtido no próprio RD Station, em Configurações -> Integração.

Changelog
---------
* 0.1.1
  * Merge do Pull Requeste por @thiesen. Marcando uma venda no RD após uma nova venda ser efetuada no magento

* 0.1.0
  * Versão inicial do módulo - conversões em vendas, assinatura de newsletter, cadastro de nova conta e formulário de contato