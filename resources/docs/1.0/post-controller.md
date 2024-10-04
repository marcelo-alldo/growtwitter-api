# Posts

-   [**Métodos Controller**](#controller)
-   [Mostrar todos os Posts](#get-posts)
-   [Mostar Post](#show-post)
-   [Fazer Post `Request`](#new-post)
-   [Editar Post `Request`](#edit-post)
-   [Excluir Post](#delete-post)

<a name="controller"></a>

## Pegar todos os posts

Este método pega todos os posts dos usuários com suas relações.

<a name="get-posts" />

### Endpoint (Pegar posts)

Para pegar todos os posts, enviar request conforme dados exemplificados abaixo.

| Method |   URL    | Headers |
| :----: | :------: | :-----: |
|  GET   | `/posts` |  Auth   |

### Responses

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
            "comments_count": "number",
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
            ],
            "comments": [
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
                        "avatar_url": "string|null",
                        "email_verified_at": "string|date|null",
                        "created_at": "string|date",
                        "updated_at": "string|date"
                    }
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

<a name="show-post" />

## Show Post

Este método pega um post pelo ID.

### Endpoint (Pegar posts)

Para pegar um post, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
|  GET   | `/posts/postId` |  Auth   |

### Responses

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

> {danger.fa-times-circle-o} Usuário não está autenticado

Código `401`

```json
{
    "success": "boolean",
    "message": "string"
}
```

<a name="new-post"></a>

## Fazer novo post

Este método cria um novo post.

#### Body rules

```json
{
    "content": "required|string|max:255"
}
```

### Endpoint (Novo post)

Postar um novo post, enviar request conforme dados exemplificados abaixo.

| Method |   URL    | Headers |
| :----: | :------: | :-----: |
|  POST  | `/posts` |  Auth   |

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

<a name="edit-post"></a>

## Editar post

Para editar um post, enviar request conforme dados exemplificados abaixo.

#### Body rules

```json
{
    "content": "required|string|max:255"
}
```

### Endpoint (Novo post)

Editar um post, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
|  PUT   | `/posts/postId` |  Auth   |

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

<a name="delete-post"></a>

## Deletar post

### Endpoint (Novo post)

Deletar um post, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
| DELETE | `/posts/postId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `201`

```json
{
    "success": "boolean",
    "msg": "string"
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
