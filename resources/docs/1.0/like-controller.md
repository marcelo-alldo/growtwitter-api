# Curtidas

-   [**Métodos Controller**](#controller)
-   [Mostrar todos os Likes](#get-likes)
-   [Mostar Like](#show-like)
-   [Fazer Like `Request`](#new-like)

<a name="controller"></a>

## Pegar todos os likes

Este método pega todos os likes dos usuários com suas relações.

<a name="get-likes" />

### Endpoint (Pegar likes)

Para pegar todos os likes, enviar request conforme dados exemplificados abaixo.

| Method |   URI    | Headers |
| :----: | :------: | :-----: |
|  GET   | `/likes` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "data": [
        {
            "id": "number",
            "userId": "number",
            "postId": "number",
            "created_at": "string|date",
            "updated_at": "string|date"
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

<a name="show-like" />

## Show Like

Este método pega um Like pelo ID.

### Endpoint (Pegar likes)

Para pegar um like, enviar request conforme dados exemplificados abaixo.

| Method |       URI       | Headers |
| :----: | :-------------: | :-----: |
|  GET   | `/likes/likeId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "id": "number",
        "userId": "number",
        "postId": "number",
        "created_at": "string|date",
        "updated_at": "string|date"
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

<a name="new-like"></a>

## Fazer novo like

Este método faz um novo like.

#### Body rules

```json
{
    "postId": "required"
}
```

### Endpoint (Novo post)

Postar um novo like, enviar request conforme dados exemplificados abaixo.

| Method |   URI    | Headers |
| :----: | :------: | :-----: |
|  POST  | `/likes` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `201`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "userId": "number",
        "content": "string",
        "updated_at": "string|date",
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
