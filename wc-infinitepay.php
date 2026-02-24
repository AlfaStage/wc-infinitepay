<?php
/*
Plugin Name: InfinitePay Checkout - AlfaStageLabs
Plugin URI: https://github.com/AlfaStage/wc-infinitepay
Description: Integração oficial InfinitePay com Verificação Ativa (Payment Check), Webhook Corrigido e Salvamento de Recibos.
Version: 1.5
Author: AlfaStageLabs
Author URI: https://github.com/AlfaStage
Text Domain: wc-infinitepay
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'plugins_loaded', 'alfastage_init_infinitepay_class' );

function alfastage_init_infinitepay_class() {
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

    class WC_InfinitePay_Gateway extends WC_Payment_Gateway {
        
        public $handle_name;
        public $api_key;

        public function __construct() {
            $this->id                 = 'infinitepay'; 
            $this->icon               = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyBpZD0iQ2FtYWRhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmlld0JveD0iMCAwIDEwMDAgMTAwMCI+CiAgPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDMwLjIuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDIuMS4xIEJ1aWxkIDEpICAtLT4KICA8ZGVmcz4KICAgIDxzdHlsZT4KICAgICAgLnN0MCB7CiAgICAgICAgZmlsbDogbm9uZTsKICAgICAgfQoKICAgICAgLnN0MSB7CiAgICAgICAgZmlsbDogdXJsKCNHcmFkaWVudGVfc2VtX25vbWVfMik7CiAgICAgICAgZmlsbC1ydWxlOiBldmVub2RkOwogICAgICB9CgogICAgICAuc3QyIHsKICAgICAgICBmaWxsOiAjMTgxNTI3OwogICAgICB9CgogICAgICAuc3QzIHsKICAgICAgICBjbGlwLXBhdGg6IHVybCgjY2xpcHBhdGgpOwogICAgICB9CiAgICA8L3N0eWxlPgogICAgPGNsaXBQYXRoIGlkPSJjbGlwcGF0aCI+CiAgICAgIDxyZWN0IGNsYXNzPSJzdDAiIHg9Ii4yOCIgeT0iLjQzIiB3aWR0aD0iOTk5LjcyIiBoZWlnaHQ9Ijk5OS43MiIvPgogICAgPC9jbGlwUGF0aD4KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iR3JhZGllbnRlX3NlbV9ub21lXzIiIGRhdGEtbmFtZT0iR3JhZGllbnRlIHNlbSBub21lIDIiIHgxPSI1MDAuMTQiIHkxPSI4MjkuMDUiIHgyPSI1MDAuMTQiIHkyPSIxNzEuMzciIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAxMDAwLjUpIHNjYWxlKDEgLTEpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+CiAgICAgIDxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iIzYyYjIyZiIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmZWM3MDgiLz4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgPC9kZWZzPgogIDxnIGNsYXNzPSJzdDMiPgogICAgPGc+CiAgICAgIDxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik01MDAuMTQsMTAwMC4xNmMyNzYuMDYsMCw0OTkuODYtMjIzLjgsNDk5Ljg2LTQ5OS44NlM3NzYuMi40Myw1MDAuMTQuNDMuMjgsMjI0LjI0LjI4LDUwMC4yOXMyMjMuOCw0OTkuODYsNDk5Ljg2LDQ5OS44NloiLz4KICAgICAgPHBhdGggY2xhc3M9InN0MSIgZD0iTTUwMC4xNCw3NTIuNDJjMTM5LjIzLDAsMjUyLjEzLTExMi45LDI1Mi4xMy0yNTIuMTNzLTExMi45LTI1Mi4xMy0yNTIuMTMtMjUyLjEzLTI1Mi4xMywxMTIuOS0yNTIuMTMsMjUyLjEzLDExMi45LDI1Mi4xMywyNTIuMTMsMjUyLjEzWk04MjguOTgsNTAwLjI5YzAsMTgxLjYyLTE0Ny4yMywzMjguODQtMzI4Ljg0LDMyOC44NHMtMzI4Ljg0LTE0Ny4yMy0zMjguODQtMzI4Ljg0UzMxOC41MiwxNzEuNDUsNTAwLjE0LDE3MS40NXMzMjguODQsMTQ3LjIzLDMyOC44NCwzMjguODRaIi8+CiAgICA8L2c+CiAgPC9nPgo8L3N2Zz4=';
            $this->has_fields         = false;
            $this->method_title       = 'InfinitePay (Cartão e PIX)';
            $this->method_description = 'Redirecionamento seguro para o checkout da InfinitePay.';

            $this->init_form_fields();
            $this->init_settings();

            $this->title       = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled     = $this->get_option( 'enabled' );
            $this->handle_name = $this->get_option( 'handle_name' );
            $this->api_key     = $this->get_option( 'api_key' );

            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            add_action( 'woocommerce_api_wc_infinitepay_webhook', array( $this, 'webhook_handler' ) );
            add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'display_infinitepay_data_in_admin' ) );
            
            // NOVO: Gatilho para quando o cliente voltar para a página de Obrigado
            add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'verify_payment_on_return' ) );
        }

        public function is_available() {
            return ( 'yes' === $this->enabled && ! empty( $this->handle_name ) );
        }

        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array( 'title' => 'Habilitar', 'type' => 'checkbox', 'default' => 'yes' ),
                'title'   => array( 'title' => 'Título no Checkout', 'type' => 'text', 'default' => 'Cartão de Crédito e PIX (InfinitePay)' ),
                'description' => array( 'title' => 'Descrição', 'type' => 'textarea', 'default' => 'Pague com segurança no ambiente da InfinitePay.' ),
                'handle_name' => array( 
                    'title' => 'Handle (InfiniteTag)', 
                    'type' => 'text', 
                    'description' => 'Sua tag da InfinitePay sem o @ (Ex: alfastagelabs).',
                    'desc_tip' => true
                ),
                'api_key' => array( 
                    'title' => 'API Token (Opcional)', 
                    'type' => 'password',
                    'description' => 'Insira o token caso sua conta exija para leitura de status.' 
                )
            );
        }

        public function process_payment( $order_id ) {
            $logger = wc_get_logger();
            $order = wc_get_order( $order_id );
            
            try {
                $webhook_url = add_query_arg( 'wc-api', 'wc_infinitepay_webhook', home_url( '/' ) );
                $redirect_url = $this->get_return_url( $order );

                $items_payload = array();
                foreach ( $order->get_items() as $item_id => $item ) {
                    $items_payload[] = array(
                        'id'          => (string) $item->get_product_id(),
                        'description' => substr($item->get_name(), 0, 100),
                        'quantity'    => $item->get_quantity(),
                        'price'       => intval( round( ($item->get_total() / $item->get_quantity()) * 100 ) )
                    );
                }

                if ( $order->get_shipping_total() > 0 ) {
                    $items_payload[] = array(
                        'id'          => 'frete',
                        'description' => 'Frete',
                        'quantity'    => 1,
                        'price'       => intval( round( $order->get_shipping_total() * 100 ) )
                    );
                }

                $phone = preg_replace('/[^0-9]/', '', $order->get_billing_phone());
                if ( strlen( $phone ) === 10 || strlen( $phone ) === 11 ) {
                    $phone = '+55' . $phone;
                } elseif ( strlen( $phone ) >= 12 ) {
                    $phone = '+' . $phone;
                }

                $cpf = preg_replace('/[^0-9]/', '', $order->get_meta('_billing_cpf'));
                
                $customer_payload = array(
                    'name'  => substr($order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), 0, 100),
                    'email' => $order->get_billing_email(),
                );

                if(!empty($phone)) $customer_payload['phone'] = (string) $phone;
                if(!empty($cpf)) $customer_payload['document'] = (string) $cpf;

                $payload = array(
                    'handle'       => $this->handle_name,
                    'order_nsu'    => (string) $order_id,
                    'redirect_url' => $redirect_url,
                    'webhook_url'  => $webhook_url,
                    'amount'       => intval( round( $order->get_total() * 100 ) ),
                    'customer'     => $customer_payload,
                    'items'        => $items_payload
                );

                $logger->info( '>>> ENVIANDO PARA INFINITEPAY: ' . json_encode($payload), array( 'source' => 'infinitepay' ) );

                $headers = array( 'Content-Type' => 'application/json' );
                if ( ! empty( $this->api_key ) ) {
                    $headers['Authorization'] = 'Bearer ' . $this->api_key;
                }

                $response = wp_remote_post( 'https://api.infinitepay.io/invoices/public/checkout/links', array(
                    'method'  => 'POST',
                    'headers' => $headers,
                    'body'    => json_encode( $payload ),
                    'timeout' => 30
                ));

                if ( is_wp_error( $response ) ) {
                    $logger->error( '!!! ERRO HTTP: ' . $response->get_error_message(), array( 'source' => 'infinitepay' ) );
                    wc_add_notice( 'Erro de conexão com a InfinitePay.', 'error' );
                    return array('result' => 'fail');
                }

                $body_raw = wp_remote_retrieve_body( $response );
                $http_code = wp_remote_retrieve_response_code( $response );
                $body = json_decode( $body_raw, true );

                $logger->info( '<<< RESPOSTA INFINITEPAY (' . $http_code . '): ' . $body_raw, array( 'source' => 'infinitepay' ) );

                if ( $http_code >= 200 && $http_code < 300 && (isset($body['url']) || isset($body['payment_url'])) ) {
                    
                    $payment_url = $body['url'] ?? $body['payment_url'];
                    $order->update_meta_data( '_infinitepay_payment_url', $payment_url );
                    $order->update_status( 'on-hold', 'Aguardando pagamento no Checkout da InfinitePay.' );
                    $order->save();

                    return array(
                        'result'   => 'success',
                        'redirect' => $payment_url,
                    );
                } else {
                    $msg_erro = $body['error'] ?? 'Erro ao gerar o link de pagamento.';
                    wc_add_notice( 'Erro na validação do pagamento: ' . $msg_erro, 'error' );
                    return array('result' => 'fail');
                }

            } catch ( Exception $e ) {
                $logger->critical( 'Erro Fatal: ' . $e->getMessage(), array( 'source' => 'infinitepay' ) );
                wc_add_notice( 'Ocorreu um erro interno.', 'error' );
                return array('result' => 'fail');
            }
        }

        // NOVO: Verifica ativamente na API se foi pago quando o cliente volta pra loja
        public function verify_payment_on_return( $order_id ) {
            $order = wc_get_order( $order_id );
            if ( ! $order || $order->is_paid() ) return;

            // Pega os parâmetros da URL de retorno (GET)
            $transaction_nsu = isset($_GET['transaction_nsu']) ? sanitize_text_field($_GET['transaction_nsu']) : '';
            $slug            = isset($_GET['slug']) ? sanitize_text_field($_GET['slug']) : '';
            $order_nsu       = isset($_GET['order_nsu']) ? sanitize_text_field($_GET['order_nsu']) : '';
            $receipt_url     = isset($_GET['receipt_url']) ? esc_url_raw($_GET['receipt_url']) : '';
            $capture_method  = isset($_GET['capture_method']) ? sanitize_text_field($_GET['capture_method']) : '';

            // Se os parâmetros essenciais existirem na URL
            if ( $transaction_nsu && $slug && $order_nsu ) {
                
                // Prepara a consulta do status
                $payload = array(
                    'handle'          => $this->handle_name,
                    'order_nsu'       => $order_nsu,
                    'transaction_nsu' => $transaction_nsu,
                    'slug'            => $slug
                );

                $headers = array( 'Content-Type' => 'application/json' );
                if ( ! empty( $this->api_key ) ) {
                    $headers['Authorization'] = 'Bearer ' . $this->api_key;
                }

                $response = wp_remote_post( 'https://api.infinitepay.io/invoices/public/checkout/payment_check', array(
                    'method'  => 'POST',
                    'headers' => $headers,
                    'body'    => json_encode( $payload ),
                    'timeout' => 15
                ));

                if ( ! is_wp_error( $response ) ) {
                    $body = json_decode( wp_remote_retrieve_body( $response ), true );
                    
                    // Se a API confirmar que foi PAGO
                    if ( isset($body['paid']) && $body['paid'] === true ) {
                        
                        // Salva os dados ricos que a API devolveu
                        $order->update_meta_data( 'infinitepay_transaction_nsu', $transaction_nsu );
                        $order->update_meta_data( 'infinitepay_slug', $slug );
                        if($receipt_url) $order->update_meta_data( 'infinitepay_receipt_url', $receipt_url );
                        if($capture_method) $order->update_meta_data( 'infinitepay_capture_method', strtoupper($capture_method) );
                        if(isset($body['installments'])) $order->update_meta_data( 'infinitepay_installments', $body['installments'] );

                        // Confirma o pagamento
                        $order->payment_complete( $transaction_nsu );
                        $order->add_order_note( "Pagamento confirmado via Retorno do Checkout (API Payment Check). NSU: " . $transaction_nsu );
                        $order->save();
                    }
                }
            }
        }

        // Exibe Dados Ricos no Admin
        public function display_infinitepay_data_in_admin( $order ) {
            if ( $order->get_payment_method() === $this->id ) {
                $tx_nsu       = $order->get_meta( 'infinitepay_transaction_nsu' );
                $slug         = $order->get_meta( 'infinitepay_slug' );
                $method       = $order->get_meta( 'infinitepay_capture_method' );
                $installments = $order->get_meta( 'infinitepay_installments' );
                $receipt      = $order->get_meta( 'infinitepay_receipt_url' );

                echo '<div style="background: #eef8ff; padding: 15px; border-radius: 5px; margin-top: 15px;">';
                echo '<strong style="display:block; margin-bottom: 8px;">Dados InfinitePay:</strong>';
                
                if ( $tx_nsu ) echo 'NSU Transação: <code>' . esc_html( $tx_nsu ) . '</code><br>';
                if ( $slug ) echo 'Slug (Fatura): <code>' . esc_html( $slug ) . '</code><br>';
                if ( $method ) echo 'Método de Pagamento: <strong>' . esc_html( $method ) . '</strong><br>';
                if ( $installments ) echo 'Parcelas: <strong>' . esc_html( $installments ) . 'x</strong><br>';
                
                if ( $receipt ) {
                    echo '<hr style="margin: 10px 0; border: 0; border-top: 1px solid #cce5ff;">';
                    echo '<a href="' . esc_url( $receipt ) . '" target="_blank" style="color: #01D46A; font-weight:bold;">🧾 Abrir Recibo de Pagamento</a>';
                }
                
                echo '</div>';
            }
        }

        // WEBHOOK Corrigido baseado no LOG real
        public function webhook_handler() {
            $logger = wc_get_logger();
            $payload = file_get_contents('php://input');
            $data = json_decode($payload, true);
            
            $logger->info( 'WEBHOOK INFINITEPAY: ' . $payload, array( 'source' => 'infinitepay' ) );

            $order_id = $data['order_nsu'] ?? null;
            $tx_id = $data['transaction_nsu'] ?? 'N/A';
            
            // No InfinitePay o Webhook não manda status "paid", ele manda o valor cobrado e o valor pago
            $amount = isset($data['amount']) ? (int) $data['amount'] : 0;
            $paid_amount = isset($data['paid_amount']) ? (int) $data['paid_amount'] : 0;

            if ( ! $order_id ) {
                $logger->error( 'WEBHOOK: order_nsu não encontrado.', array( 'source' => 'infinitepay' ) );
                status_header(400); exit('Bad Request'); 
            }

            $order = wc_get_order( $order_id );

            if ( $order ) {
                // Atualiza os meta dados com o que vier do webhook
                if ( isset($data['transaction_nsu']) ) $order->update_meta_data( 'infinitepay_transaction_nsu', $data['transaction_nsu'] );
                if ( isset($data['invoice_slug']) )    $order->update_meta_data( 'infinitepay_slug', $data['invoice_slug'] );
                if ( isset($data['capture_method']) )  $order->update_meta_data( 'infinitepay_capture_method', strtoupper($data['capture_method']) );
                if ( isset($data['installments']) )    $order->update_meta_data( 'infinitepay_installments', $data['installments'] );
                if ( isset($data['receipt_url']) )     $order->update_meta_data( 'infinitepay_receipt_url', $data['receipt_url'] );
                
                $order->save();

                if ( ! $order->is_paid() ) {
                    // Validação de pagamento: Se o valor pago for maior ou igual ao valor cobrado
                    if ( $paid_amount > 0 && $paid_amount >= $amount ) {
                        $order->payment_complete( $tx_id );
                        $order->add_order_note( "Pagamento confirmado via Webhook. NSU: $tx_id" );
                        $order->save();

                        $logger->info( "WEBHOOK: Pedido #$order_id aprovado com sucesso.", array( 'source' => 'infinitepay' ) );
                        status_header(200); exit('OK'); 
                    } else {
                        $logger->info( "WEBHOOK: Pedido #$order_id não atingiu valor total.", array( 'source' => 'infinitepay' ) );
                        status_header(200); exit('Valor incompleto');
                    }
                }
            }
            
            status_header(200); exit('Already processed');
        }
    }
    add_filter( 'woocommerce_payment_gateways', function( $methods ) { $methods[] = 'WC_InfinitePay_Gateway'; return $methods; } );
}

// BOTÃO DE PAGAMENTO (E-MAIL AGUARDANDO)
add_action( 'woocommerce_email_before_order_table', 'alfastage_infinitepay_email_button', 15, 4 );
function alfastage_infinitepay_email_button( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $sent_to_admin || $order->get_payment_method() !== 'infinitepay' || ! $order->has_status('on-hold') ) return;

    $payment_url = $order->get_meta( '_infinitepay_payment_url' );
    
    if ( $payment_url ) {
        echo '<div style="text-align: center; margin: 30px 0; padding: 20px; border: 1px solid #e5e5e5; background-color: #fdfdfd; border-radius: 5px;">';
        echo '<h2 style="color: #181527;">Aguardando Pagamento</h2>';
        echo '<p>Seu pedido está reservado! Clique no botão abaixo para ir para a tela segura da InfinitePay e finalizar sua compra.</p>';
        echo '<a href="' . esc_url( $payment_url ) . '" style="display: inline-block; background-color: #01D46A; color: #ffffff; padding: 12px 24px; text-decoration: none; font-weight: bold; border-radius: 4px; font-size: 16px;">Pagar Pedido Agora</a>';
        echo '</div>';
    }
}

// RECIBO (E-MAIL DE PEDIDO PROCESSANDO/PAGO)
add_action( 'woocommerce_email_after_order_table', 'alfastage_infinitepay_receipt_email', 10, 4 );
function alfastage_infinitepay_receipt_email( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $sent_to_admin || $order->get_payment_method() !== 'infinitepay' ) return;

    if ( $order->has_status( array('processing', 'completed') ) ) {
        $receipt_url = $order->get_meta( 'infinitepay_receipt_url' );
        if ( $receipt_url ) {
            echo '<div style="margin-top: 30px; padding: 15px; border-left: 4px solid #01D46A; background-color: #f9f9f9;">';
            echo '<h3 style="margin-top:0; color: #181527;">Recibo do Pagamento</h3>';
            echo '<p>Seu pagamento foi confirmado pela InfinitePay. Você pode acessar seu comprovante oficial no link abaixo:</p>';
            echo '<p><a href="' . esc_url( $receipt_url ) . '" target="_blank" style="color: #01D46A; font-weight: bold; text-decoration: none;">📄 Ver Recibo Oficial da Transação</a></p>';
            echo '</div>';
        }
    }
}

add_action( 'woocommerce_blocks_payment_method_type_registration', function( $registry ) {
    if ( ! class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) return;
    class WC_InfinitePay_Blocks_Support extends Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType {
        protected $name = 'infinitepay';
        public function initialize() { $this->settings = get_option( 'woocommerce_infinitepay_settings', [] ); }
        public function is_active() { return ! empty( $this->settings['enabled'] ) && 'yes' === $this->settings['enabled']; }
        public function get_payment_method_script_handles() {
            wp_register_script('wc-infinitepay-blocks', plugin_dir_url( __FILE__ ) . 'block.js', array( 'wc-blocks-registry', 'wc-settings', 'wp-element', 'wp-html-entities', 'wp-i18n' ), '1.5', true);
            return array( 'wc-infinitepay-blocks' );
        }
        public function get_payment_method_data() {
            return array(
                'title' => $this->get_setting( 'title' ),
                'description' => $this->get_setting( 'description' ),
                'icon_url' => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyBpZD0iQ2FtYWRhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmlld0JveD0iMCAwIDEwMDAgMTAwMCI+CiAgPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDMwLjIuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDIuMS4xIEJ1aWxkIDEpICAtLT4KICA8ZGVmcz4KICAgIDxzdHlsZT4KICAgICAgLnN0MCB7CiAgICAgICAgZmlsbDogbm9uZTsKICAgICAgfQoKICAgICAgLnN0MSB7CiAgICAgICAgZmlsbDogdXJsKCNHcmFkaWVudGVfc2VtX25vbWVfMik7CiAgICAgICAgZmlsbC1ydWxlOiBldmVub2RkOwogICAgICB9CgogICAgICAuc3QyIHsKICAgICAgICBmaWxsOiAjMTgxNTI3OwogICAgICB9CgogICAgICAuc3QzIHsKICAgICAgICBjbGlwLXBhdGg6IHVybCgjY2xpcHBhdGgpOwogICAgICB9CiAgICA8L3N0eWxlPgogICAgPGNsaXBQYXRoIGlkPSJjbGlwcGF0aCI+CiAgICAgIDxyZWN0IGNsYXNzPSJzdDAiIHg9Ii4yOCIgeT0iLjQzIiB3aWR0aD0iOTk5LjcyIiBoZWlnaHQ9Ijk5OS43MiIvPgogICAgPC9jbGlwUGF0aD4KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iR3JhZGllbnRlX3NlbV9ub21lXzIiIGRhdGEtbmFtZT0iR3JhZGllbnRlIHNlbSBub21lIDIiIHgxPSI1MDAuMTQiIHkxPSI4MjkuMDUiIHgyPSI1MDAuMTQiIHkyPSIxNzEuMzciIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAxMDAwLjUpIHNjYWxlKDEgLTEpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+CiAgICAgIDxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iIzYyYjIyZiIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmZWM3MDgiLz4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgPC9kZWZzPgogIDxnIGNsYXNzPSJzdDMiPgogICAgPGc+CiAgICAgIDxwYXRoIGNsYXNzPSJzdDIiIGQ9Ik01MDAuMTQsMTAwMC4xNmMyNzYuMDYsMCw0OTkuODYtMjIzLjgsNDk5Ljg2LTQ5OS44NlM3NzYuMi40Myw1MDAuMTQuNDMuMjgsMjI0LjI0LjI4LDUwMC4yOXMyMjMuOCw0OTkuODYsNDk5Ljg2LDQ5OS44NloiLz4KICAgICAgPHBhdGggY2xhc3M9InN0MSIgZD0iTTUwMC4xNCw3NTIuNDJjMTM5LjIzLDAsMjUyLjEzLTExMi45LDI1Mi4xMy0yNTIuMTNzLTExMi45LTI1Mi4xMy0yNTIuMTMtMjUyLjEzLTI1Mi4xMywxMTIuOS0yNTIuMTMsMjUyLjEzLDExMi45LDI1Mi4xMywyNTIuMTMsMjUyLjEzWk04MjguOTgsNTAwLjI5YzAsMTgxLjYyLTE0Ny4yMywzMjguODQtMzI4Ljg0LDMyOC44NHMtMzI4Ljg0LTE0Ny4yMy0zMjguODQtMzI4Ljg0UzMxOC41MiwxNzEuNDUsNTAwLjE0LDE3MS40NXMzMjguODQsMTQ3LjIzLDMyOC44NCwzMjguODRaIi8+CiAgICA8L2c+CiAgPC9nPgo8L3N2Zz4=',
                'supports' => array( 'products' ),
            );
        }
    }
    $registry->register( new WC_InfinitePay_Blocks_Support() );
} );
