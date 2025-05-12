<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# Payment Service - Sistema de E-commerce com Microsserviços

Este microsserviço é responsável pelo processamento de pagamentos no sistema de e-commerce distribuído. Ele consulta os dados de um pedido existente, simula a efetivação do pagamento e atualiza o status do pedido no backend. Após a confirmação, também limpa o carrinho de compras do usuário.

## Funcionalidades

* Consultar um pedido a partir do seu ID
* Simular o pagamento de um pedido
* Atualizar o status do pedido como "pago"
* Limpar o carrinho do usuário após o pagamento

## Integração com outros serviços

Este serviço se comunica com os seguintes microsserviços por meio do API Gateway:

| Serviço       | Finalidade da integração                                        |
| ------------- | --------------------------------------------------------------- |
| order-service | Recuperar e atualizar o status do pedido                        |
| cart-service  | Limpar os itens do carrinho após o pagamento                    |
| gateway       | Todas as chamadas externas são roteadas por ele (`APP_GATEWAY`) |

## Rotas disponíveis

As rotas estão protegidas por middleware de autenticação JWT.

### GET `/api/service/payment/payment`

Consulta um pedido pelo `order_id` e retorna as informações do pedido junto ao link para simulação de pagamento.

**Parâmetros da requisição:**

```json
{
  "order_id": "123"
}
```

**Resposta de sucesso:**

```json
{
  "payment": {
    "link": "http://localhost:8000/api/service/payment/payment",
    "method": "post"
  },
  "order": { ... }
}
```

### POST `/api/service/payment/payment`

Efetiva o pagamento de um pedido e realiza as seguintes ações:

1. Consulta o pedido
2. Atualiza seu status
3. Limpa o carrinho do usuário

**Parâmetros da requisição:**

```json
{
  "order_id": "123"
}
```

**Resposta de sucesso:**

```json
{
  "message": "Pagamento efetuado com sucesso!",
  "order": { ... }
}
```

## Estrutura do projeto

| Arquivo                 | Função                                                   |
| ----------------------- | -------------------------------------------------------- |
| `PaymentController.php` | Controlador principal, com ações de consulta e pagamento |
| `routes/api.php`        | Define as rotas da API protegidas por JWT                |

## Requisitos

* Laravel 11
* PHP 8.2+
* Token de autenticação válido (JWT)
* API Gateway configurado via variável `APP_GATEWAY`

## Observações

Este microsserviço não processa pagamentos reais. Ele simula o fluxo de pagamento para fins de teste e integração entre serviços. O status do pedido é alterado internamente como se o pagamento tivesse sido aprovado com sucesso.

---
