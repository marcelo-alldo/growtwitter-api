# follower

-   [**Métodos Controller**](#controller)
-   [Mostrar todos os Seguidores](#get-follower)
-   [Mostar Seguidor](#show-follower)
-   [Seguir Usuario `Request`](#new-follower)

<a name="controller"></a>

## Pegar todos os seguidores

Este método pega todos os follower dos usuários com suas relações.

<a name="get-follower" />

### Endpoint (Pegar seguidores)

Para pegar todos os followers, enviar request conforme dados exemplificados abaixo.

| Method |    URL    | Headers |
| :----: | :-------: | :-----: |
|  GET   | `/follow` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": [
        {
            "id": "number",
            "created_at": "string|date",
            "updated_at": "string|date",
            "followingId": "number",
            "followerId": "number"
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

<a name="show-follower" />

## Show Seguidor

Este método pega um follower pelo ID.

### Endpoint (Pegar follower)

Para pegar um follower, enviar request conforme dados exemplificados abaixo.

| Method |       URL        | Headers |
| :----: | :--------------: | :-----: |
|  GET   | ` follow/postId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "followings": "number",
    "followers": "number",
    "followingsData": [
        {
            "id": "number",
            "created_at": "string|date",
            "updated_at": "string|date",
            "followingId": "number",
            "followerId": "number",
            "follower": {
                "id": "number",
                "name": "string",
                "surname": "string",
                "email": "string",
                "username": "string",
                "avatar_url": "string|nullable",
                "email_verified_at": "null",
                "created_at": "string|date",
                "updated_at": "string|date"
            },
            "following": {
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
            "posts": [
                {
                    "id": "number",
                    "content": "string",
                    "userId": "number",
                    "created_at": "string|date",
                    "updated_at": "string|date"
                }
            ]
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

<a name="new-follower"></a>

## Seguir um novo usuario

Este método segue um usuario novo.

#### Body rules

```json
{
    "followingId":"required",
    "followerId": "required"
}
```

### Endpoint (Novo Seguidor)

Seguir um novo usuario, enviar request conforme dados exemplificados abaixo.

| Method |    URL    | Headers |
| :----: | :-------: | :-----: |
|  POST  | ` follow` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `201`

```json
{
    "success": "boolean",
    "msg": "string",
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
