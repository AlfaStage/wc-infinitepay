(function( window, wp ) {
    const { registerPaymentMethod } = window.wc.wcBlocksRegistry;
    const { getPaymentMethodData } = window.wc.wcSettings;
    const { decodeEntities } = window.wp.htmlEntities; 
    const { createElement } = window.wp.element;

    // Busca os dados do PHP (id: 'infinitepay')
    const settings = getPaymentMethodData( 'infinitepay', {} );

    const defaultTitle = 'Cartão de Crédito e PIX (InfinitePay)';
    const defaultDesc = 'Pague com segurança no ambiente da InfinitePay.';
    const iconUrl = settings.icon_url || '';
    const labelText = decodeEntities( settings.title || defaultTitle );
    
    // Cria o Ícone da InfinitePay
    const iconElement = createElement('img', {
        src: iconUrl, alt: 'InfinitePay',
        style: { width: '24px', height: '24px', marginRight: '10px', verticalAlign: 'middle', objectFit: 'contain' }
    });

    // Cria o Título
    const titleElement = createElement('span', {
        style: { fontWeight: 'bold', fontSize: '1em', verticalAlign: 'middle', color: '#1e1e1e' }
    }, labelText);

    // Junta Ícone + Título
    const labelContainer = createElement('div', {
        style: { display: 'flex', alignItems: 'center', width: '100%' }
    }, iconElement, titleElement);

    // Cria a Descrição
    const Content = () => {
        return createElement(
            'div',
            { className: 'wc-block-components-payment-method-details' },
            decodeEntities( settings.description || defaultDesc )
        );
    };

    // Registra no WooCommerce
    registerPaymentMethod( {
        name: "infinitepay", // ID TEM QUE SER IGUAL AO PHP
        label: labelContainer,
        content: createElement( Content, null ),
        edit: createElement( Content, null ),
        canMakePayment: () => true,
        ariaLabel: labelText,
        supports: { features: settings.supports || ['products'] },
    } );

})( window, window.wp );
