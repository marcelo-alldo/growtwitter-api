# Usuários

-   [**Métodos Controller**](#get-users)
-   [Criar conta `Request`](#request-register)
-   [Pegar todos os Usuários](#get-user)
-   [Pegar um Usuário](#show-user)

<a name="sign-up"></a>

## Cadastro de novos usuários

O cadastro de usuários é feito de forma independente em um serviço de autenticação. Após o cadastro criado neste serviço, um registro será criado na tabela `users`. Este registro, será utilizado como usuário nas áreas autenticadas.

<a name="request-register"></a>

### Endpoint (Criar conta)

Para criar um novo usuário, enviar request conforme dados exemplificados abaixo.

| Method |   URL    | Headers |
| :----: | :------: | :-----: |
|  POST  | `/users` |    -    |

#### Body rules

```json
{
    "name": "required|string|max:255",
    "surname": "required|string|max:255",
    "username": "required|string|max:30|min:5|unique:users|regex:/^[w]+$/",
    "email": "required|email|unique:users",
    "password": "required|max:255|min:6|regex:/^[A-Za-z0-9@!-_#]+$/",
    "avatar_url": "string|nullable"
}
```

### Responses

> {success.fa-check-circle-o} Usuário cadastrado

Código `201`

```json
{
    "success": "boolean",
    "msg": "string",
    "user": {
        "username": "string",
        "email": "string",
        "name": "string",
        "surname": "string",
        "updated_at": "string|date",
        "created_at": "string|date",
        "id": "number"
    },
    "token": "string"
}
```

> {danger.fa-times-circle-o} E-mail ou Username em uso por outro usuário

Código `422`

```json
{
    "success": "boolean",
    "message": "string"
}
```

<a name="get-users" />

## Pegar todos os usuários

O GET de usuários é feito após o serviço de autenticação. Permitindo o cliente acessar seu usuário quando autenticado.

<a name="get-user" />

### Endpoint (Pegar usuários)

Para criar um novo usuário, enviar request conforme dados exemplificados abaixo.

| Method |   URL    | Headers |
| :----: | :------: | :-----: |
|  GET   | `/users` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário autenticado com seus posts

Código `201`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "id": "number",
        "name": "string",
        "surname": "string",
        "email": "string",
        "username": "string",
        "avatar_url": null,
        "email_verified_at": null,
        "created_at": "string|date",
        "updated_at": "string|date",
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
}
```

> {danger.fa-times-circle-o} Usuário não está autenticado

Código `422`

```json
{
    "success": "boolean",
    "message": "string"
}
```

<a name="show-user" />

## Mostrar Usuário

Este método pega um user pelo ID.

### Endpoint (Pegar users)

Para pegar um user, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
|  GET   | `/users/userId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "id": "number",
        "name": "string",
        "surname": "string",
        "email": "string",
        "username": "string",
        "avatar_url": null,
        "email_verified_at": null,
        "created_at": "string|date",
        "updated_at": "string|date",
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

<a name="edit-user"></a>

## Editar Usuário

Para editar um user, enviar request conforme dados exemplificados abaixo.

#### Body rules

```json
{
    "username": "nullable|string|max:30|min:5|unique:users|regex:/^[w]+$/",
    "email": "nullable|email|unique:users",
    "name": "nullable|string|max:255",
    "surname": "nullable|string|max:255",
    "password": "nullable|min:5|max:255",
    "avatar_url": "string|nullable"
}
```

### Endpoint (Novo post)

Editar um post, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
|  PUT   | `/users/userId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `201`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "id": "number",
        "name": "string",
        "surname": "string",
        "email": "string",
        "username": "string",
        "avatar_url": null,
        "email_verified_at": null,
        "created_at": "string|date",
        "updated_at": "string|date",
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

<a name="delete-user"></a>

## Deletar Usuário

### Endpoint (Novo user)

Deletar um user, enviar request conforme dados exemplificados abaixo.

| Method |       URL       | Headers |
| :----: | :-------------: | :-----: |
| DELETE | `/users/userId` |  Auth   |

### Responses

> {success.fa-check-circle-o} Usuário está autenticado e tem permissão para acessar este recurso

Código `200`

```json
{
    "success": "boolean",
    "msg": "string",
    "data": {
        "id": "number",
        "name": "string",
        "surname": "string",
        "email": "string",
        "username": "string",
        "avatar_url": null,
        "email_verified_at": null,
        "created_at": "string|date",
        "updated_at": "string|date",
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
