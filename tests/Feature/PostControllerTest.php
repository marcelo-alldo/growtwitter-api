<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_pode_criar_um_post()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Prepara dados do post
        $postData = [
            'content' => 'Este é um post de teste',
        ];

        // Envia requisição POST para criar um post
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/posts', $postData);

        // Verifica resposta
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'msg' => 'Post cadastrado com sucesso!',
                'data' => [
                    'userId' => $user->id,
                    'content' => 'Este é um post de teste',
                ],
            ]);

        // Post está no banco de dados
        $this->assertDatabaseHas('posts', [
            'userId' => $user->id,
            'content' => 'Este é um post de teste',
        ]);
    }
    public function test_criar_um_post_exige_content()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Envia requisição POST sem content
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/posts', []);

        // Verifica erros de validação
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'msg' => 'O campo content é obrigatório.',
            ]);
    }
    public function test_usuario_nao_autenticado_nao_pode_criar_um_post()
    {
        // Envia requisição POST sem autenticação
        $response = $this->postJson('/api/posts', [
            'content' => 'Post não autorizado',
        ]);

        // Verifica não autorizado
        $response->assertStatus(401);
    }
    public function test_usuario_autenticado_pode_ver_todos_os_posts()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Cria múltiplos posts
        Post::factory()->count(3)->create([
            'userId' => $user->id,
        ]);

        // Envia requisição GET para recuperar posts
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/posts');

        // Verifica estrutura da resposta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'userId',
                        'content',
                        'created_at',
                        'updated_at',
                        // Relações se carregadas
                    ],
                ],
            ]);
    }
    public function test_usuario_autenticado_pode_atualizar_seu_post()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Cria um post
        $post = Post::factory()->create([
            'userId' => $user->id,
            'content' => 'Conteúdo Original',
        ]);

        // Prepara dados de atualização
        $updateData = [
            'content' => 'Conteúdo Atualizado',
        ];

        // Envia requisição PUT para atualizar o post
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/posts/{$post->id}", $updateData);

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Post editado com sucesso!',
                'data' => [
                    'id' => $post->id,
                    'content' => 'Conteúdo Atualizado',
                ],
            ]);

        //  Banco de dados está atualizado
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'content' => 'Conteúdo Atualizado',
        ]);
    }
    public function test_usuario_autenticado_pode_deletar_seu_post()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Cria um post
        $post = Post::factory()->create([
            'userId' => $user->id,
        ]);

        // Envia requisição DELETE para remover o post
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/posts/{$post->id}");

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => "Post nº {$post->id} excluído com sucesso!",
            ]);

        // Post foi deletado do banco de dados
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

}
