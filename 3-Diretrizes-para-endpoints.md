# Diretrizes para EndPoints
1. **Endpoint: ==/v1/gateway/dynamic-qrcode (POST)**==
    - Este endpoint é utilizado para criar uma cobrança PIX com QR Code dinâmico.
    - Na solicitação POST, os parâmetros necessários podem incluir informações sobre a transação, como o valor da cobrança, informações do cliente, etc.
    - A resposta esperada pode incluir o QR Code gerado e outras informações relevantes da cobrança.
    - Certifique-se de documentar adequadamente os parâmetros da solicitação e o formato da resposta.
2. **Endpoint: ==/v1/gateway/withdraw/pix (POST)**==
    - Este endpoint é utilizado para criar uma transação de saque PIX.
    - Na solicitação POST, os parâmetros necessários podem incluir o valor do saque e informações sobre a conta do cliente.
    - A resposta esperada pode incluir informações sobre a transação de saque, como ID da transação, status, etc.
    - Novamente, é importante documentar claramente os parâmetros da solicitação e o formato da resposta para facilitar a integração com a API.
3. **Endpoint: ==/v1/gateway/dynamic-qrcode/{id} (GET)**==
    - Este endpoint é utilizado para consultar o status de uma cobrança PIX criada anteriormente.
    - Na solicitação GET, o parâmetro necessário pode ser o ID da transação ou outra identificação única da cobrança.
    - A resposta esperada pode incluir o status da cobrança PIX e outras informações relevantes.
4. **Endpoint: ==/v1/gateway/withdraw/pix/{id} (GET)**==
    - Este endpoint é utilizado para consultar o status de uma transação de saque PIX realizada anteriormente.
    - Na solicitação GET, o parâmetro necessário pode ser o ID da transação de saque ou outra identificação única.
    - A resposta esperada pode incluir o status da transação de saque PIX e detalhes adicionais, conforme necessário.
Essas diretrizes ajudarão a garantir uma implementação precisa e consistente dos endpoints da API, facilitando sua integração por parte dos desenvolvedores. Certifique-se de documentar completamente cada endpoint, incluindo os parâmetros da solicitação e o formato das respostas, para uma fácil utilização por parte dos consumidores da API.