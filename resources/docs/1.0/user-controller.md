# Usuários

-   [**Métodos Controller**](#get-users)
-   [Criar conta `Request`](#request-register)
-   [Pegar todos os Usuários](#get-user)

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
|  GET   | `/users` |  Auth  |

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


