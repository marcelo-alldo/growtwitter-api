<a name="get-user"></a>

# Get User

### Endpoint (Visualizar único)

Obtém um resumo de um o usuário.

>

| Method |     URL      | Headers |
| :----: | :----------: | :-----: |
|  GET   | `/api/users` |  Auth   |

### Responses

> {success.fa-check-circle-o} Sucesso

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
        "avatar_url": "string",
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

> {danger.fa-check-circle-o} Erro ao tentar achar o User

Código `400`

```json
{
    "success": "boolean",
    "msg": "string",
}
```

<a name="register"></a>

# Register

### Endpoint (Cadastrar um User)

Cadastra um novo User no sistema.

>

| Method |     URL      | Headers |
| :----: | :----------: | :-----: |
|  POST  | `/api/users` |    -    |

#### Body rules

```json
{
    "name": "string",
    "surname": "string",
    "username": "string",
    "email": "string",
    "password": "string",
    "avatar_url": "string|optional"
}
```

### Responses

> {success.fa-check-circle-o} Sucesso

Código `200`

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


> {danger.fa-check-circle-o} Erro ao registrar User

Código `400`

```json
{
    "success": "boolean",
    "msg": "string",
}
```

<a name="Update"></a>

# Update

Teste

<a name="Delete"></a>

# Delete

Teste
