<?php
    /**
     * Executado quando o plugin é desinstalado.
     *
     * Ao codificar esse arquivo, considerar o fluxo de controle abaixo:
     *
     * - O método deve ser estático
     * - Checar se o conteúdo da variável $_REQUEST realmente possui o nome do plugin
     * - Fazer uma checagem de referência ao admin para ter certeza que passa pela autenticação
     * - Verificar se a saída de $_GET faz sentido
     * - Verify the output of $_GET makes sense
     * - Repetir com outros papéis. Melhor fazer direntamente usando parâmetros links/query string
     * - Repetir para multisite. Once for a single site in the network, once sitewide.
     * 
     */

    // Sai se não é chamado pelo Wordpress.
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        exit;
    }

    $options = [
        'badwords_filter_enable_for_content',
        'badwords_filter_enable_for_comments',
        'badwords_filter_replacement',
        'badwords_filter_list'
    ];

    foreach($options as $option) {
        unregister_setting(
            'badwords_filter_admin',
            $option
        );

        delete_option($option);
    }
