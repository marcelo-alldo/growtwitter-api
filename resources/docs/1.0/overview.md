# Introdução

---

- [Introdução](#introdução)
  - [Boas-vindas](#boas-vindas)
  - [Funcionamento Controllers](#funcionamento-controllers)
  - [Responses](#responses)

<a name="boas-vindas"></a>

## Boas-vindas

Bem vindo a documenta o da API do GrowTwitter, uma API que te permite criar
um clone do Twitter. Aqui você vai encontrar todas as rotas, parâmetros e
retornos.

<a name="funcionamento-controllers"></a>

## Funcionamento Controllers

Exemplo de funcionamento de controller: A controller de **Posts** é responsável por gerenciar todas as operações relacionadas às postagens dos usuários na aplicação. Ela oferece endpoints para a criação, visualização, edição e exclusão de posts. Além disso, possibilita acessar informações adicionais sobre interações como curtidas, retweets e comentários, facilitando o gerenciamento e exibição de conteúdo dinâmico.

Os principais **métodos** incluem CRUD (Create, Read, Update, Delete).:

- Pegar todos os posts com suas respectivas relações (likes, retweets, comentários).
- Exibir um post específico pelo ID.
- Criar um novo post.
- Editar um post existente.
- Excluir um post.

Todos os endpoints exigem autenticação via header `Auth`, garantindo que apenas usuários autenticados possam interagir com os recursos.

Caso o retorno seja positivo você verá sempre algo neste sentido:

<a name="responses"></a>

## Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "data": [
        {
            "id": "number",
            "content": "string",
            "userId": "number",
            "created_at": "string|date",
            "updated_at": "string|date",
            "likes_count": "number",
            "user": {
                "id": "number",
                "username": "string",
                "name": "string",
                "avatar_url": "string|null"
            },
            "likes": [
                {
                    "id": "number",
                    "userId": "number",
                    "postId": "number",
                    "created_at": "string|date",
                    "updated_at": "string|date"
                }
            ],
            "retweets": [
                {
                    "id": "number",
                    "userId": "number",
                    "postId": "number",
                    "content": "string|null",
                    "created_at": "string|date",
                    "updated_at": "string|date"
                }
            ]
        }
    ]
}
```

E para exemplos negativos:

> {danger.fa-times-circle-o} Usuário não está autenticado

Código `401`

```json
{
    "success": "boolean",
    "message": "string"
}
```
