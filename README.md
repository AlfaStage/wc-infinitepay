# InfinitePay Checkout para WooCommerce - AlfaStageLabs

![WooCommerce](https://img.shields.io/badge/WooCommerce-96588a?style=for-the-badge&logo=woocommerce&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Version](https://img.shields.io/badge/Version-1.5-green?style=for-the-badge)

A integração definitiva para receber pagamentos via **Cartão de Crédito** e **PIX** no seu WooCommerce através do checkout seguro da **InfinitePay**. Desenvolvido com foco em alta conversão, segurança e recuperação de vendas.

## 🚀 Funcionalidades Exclusivas (Versão 1.5)

*   **⚡ Verificação Ativa em Tempo Real (Payment Check):** O plugin não depende apenas do Webhook. Quando o cliente finaliza o pagamento e volta para a loja, o sistema consulta a API da InfinitePay nos bastidores e aprova o pedido instantaneamente.
*   **🔗 Webhook Dinâmico (Zero Configuração):** Diferente de outras plataformas, você não precisa configurar URLs de Webhook manualmente no painel da InfinitePay. O plugin injeta a URL de retorno invisivelmente em cada transação.
*   **🧾 Recibo Oficial no E-mail:** Assim que o pagamento é aprovado, o e-mail de "Pedido Processando" do WooCommerce envia automaticamente um botão com o link para o **Recibo Oficial da InfinitePay**.
*   **🛒 Recuperação de Vendas:** Se o cliente fechar a tela sem pagar, o e-mail de "Aguardando Pagamento" conterá um botão de destaque "Pagar Pedido Agora", levando-o de volta ao checkout da InfinitePay.
*   **📊 Dados Ricos no Admin:** NSU da transação, Parcelas, Método de Captura (PIX ou Cartão) e Slug da Fatura ficam salvos e visíveis dentro da página do pedido no painel do WordPress.
*   **📱 Formatação Automática de Telefone:** O plugin corrige e adiciona o DDI (`+55`) automaticamente, evitando recusas da API por formato de telefone inválido.
*   **🧩 Compatibilidade com Blocos:** Suporte nativo ao novo Checkout de Blocos (Gutenberg) do WooCommerce, com o logo oficial da InfinitePay.

## 📦 Instalação

1.  Faça o download do plugin ou clone este repositório:
    ```bash
    git clone https://github.com/AlfaStage/wc-infinitepay.git
    ```
2.  Mova a pasta `wc-infinitepay` para o diretório `/wp-content/plugins/` do seu WordPress.
3.  No seu painel de administração, vá em **Plugins > Plugins Instalados**.
4.  Ative o plugin **InfinitePay Checkout - AlfaStageLabs**.

## ⚙️ Configuração (Passo a Passo)

A configuração é extremamente simples:

1. Vá em **WooCommerce > Configurações > Pagamentos**.
2. Clique em **InfinitePay (Cartão e PIX)**.
3. Marque a opção **Habilitar**.
4. **Handle (InfiniteTag):** Insira o seu nome de usuário da InfinitePay *sem o @*. (Exemplo: se sua tag é `@minhaloja`, digite apenas `minhaloja`).
5. **API Token (Opcional):** Caso sua conta exija autenticação para gerar links, insira o seu Bearer Token gerado no painel de desenvolvedores da InfinitePay.
6. Salve as alterações.

## 🛠 Como o Fluxo Funciona

1. O cliente escolhe "InfinitePay" no checkout.
2. O pedido é criado como **Aguardando Pagamento** (reservando o estoque de forma segura).
3. O WooCommerce redireciona o cliente para o ambiente seguro da `checkout.infinitepay.io`.
4. O cliente efetua o pagamento (PIX ou Cartão em até 12x).
5. O cliente retorna à página de "Obrigado" do seu site.
6. O plugin verifica a transação na hora e muda o status para **Processando**.

## 🐛 Troubleshooting e Logs

**O pedido não mudou o status para pago?**
*   Verifique se a sua conta InfinitePay está habilitada para receber pagamentos via Link de Pagamento.
*   O Webhook pode demorar alguns segundos caso o cliente feche a aba antes de voltar ao site. Aguarde e recarregue a página de pedidos.

**Onde vejo os erros de integração?**
O plugin possui um sistema de *Log* completo. Vá em **WooCommerce > Status > Logs** e procure por `infinitepay` no menu suspenso. Você verá o JSON exato enviado (Carrinho, Cliente, Valores) e a resposta da API, facilitando qualquer diagnóstico.

## 📄 Licença e Créditos

Desenvolvido por [AlfaStageLabs](https://github.com/AlfaStage).
Uso livre para toda a comunidade de e-commerce e desenvolvedores WordPress.

---
*Aviso Legal: Este plugin não foi desenvolvido pela InfinitePay (CloudWalk), sendo uma solução de código aberto criada de forma independente utilizando a API pública disponibilizada pela adquirente.*
