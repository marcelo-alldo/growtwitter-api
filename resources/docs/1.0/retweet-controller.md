# Posts

-   [**Métodos Controller**](#controller)
-   [Mostrar todos os Posts](#get-retweet)
-   [Fazer Post `Request`](#new-retweet)

<a name="controller"></a>

## Pegar todos os retweets

Este método pega todos os retweets dos usuários com suas relações.

<a name="get-retweet" />

### Endpoint (Pegar posts)

Para pegar todos os posts, enviar request conforme dados exemplificados abaixo.

| Method |    URI     | Headers |
| :----: | :--------: | :-----: |
|  GET   | `/retweet` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": true,
    "data": [
        {
            "id": "number",
            "userId": "number",
            "postId": "number",
            "content": "string",
            "created_at": "string|date",
            "updated_at": "string|date",
            "user": {
                "id": "number",
                "name": "string",
                "surname": "string",
                "email": "string",
                "username": "string",
                "avatar_url": "string|nullable",
                "email_verified_at": null,
                "created_at": "string|date",
                "updated_at": "string|date"
            },
            "post": {
                "id": "number",
                "content": "string",
                "userId": "number",
                "created_at": "string|date",
                "updated_at": "string|date"
            }
        }
    ]
}
```

> {danger.fa-times-circle-o} Usuário não está autenticado

Código `401`

```json
{
    "success": "boolean",
    "message": "string"
}
```

<a name="new-retweet"></a>

## Fazer novo post

Este método cria um novo retweet.

#### Body rules

```json
{
    "postId": "required",
    "content": "nullable"
}
```

### Endpoint (Novo post)

Postar um novo post, enviar request conforme dados exemplificados abaixo.

| Method |   URI    | Headers |
| :----: | :------: | :-----: |
|  POST  | `/retweet` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `201`

```json
{
    "success": true,
    "msg": "Retweetado com sucesso!",
    "data": {
        "userId": "number",
        "postId": "number",
        "content": "string",
        "updated_at": "string|date000000Z",
        "created_at": "string|date",
        "id": "number"
    }
}
```

> {danger.fa-times-circle-o} Usuário não está autenticado

Código `401`

```json
{
    "success": "boolean",
    "message": "string"
}
```
