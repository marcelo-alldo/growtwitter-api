<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_usuario_autenticado_pode_curtir_um_post()
    {
        // Cria um usuário, autentica e cria um post
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $post = Post::factory()->create();

        // Envia requisição POST para curtir o post
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/likes', [
                'postId' => $post->id,
            ]);

        //  Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Curtida aplicada',
                'data' => [
                    'postId' => $post->id,
                    'userId' => $user->id,
                ],
            ]);

        //  Like existe no banco de dados
        $this->assertDatabaseHas('likes', [
            'postId' => $post->id,
            'userId' => $user->id,
        ]);
    }
    public function test_usuario_autenticado_pode_descurtir_um_post()
    {
        // Cria um usuário, autentica, um post e um like
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $post = Post::factory()->create();

        $like = Like::factory()->create([
            'postId' => $post->id,
            'userId' => $user->id,
        ]);

        // Envia requisição POST para descurtir o post
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/likes', [
                'postId' => $post->id,
            ]);

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Curtida removida',
            ]);

        // Like é removido do banco de dados
        $this->assertDatabaseMissing('likes', [
            'postId' => $post->id,
            'userId' => $user->id,
        ]);
    }
    public function test_curtir_um_post_exige_postId()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Envia requisição POST sem postId
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/likes', []);

        // Verifica erros de validação
        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'msg' => 'Curtida não aplicada',
            ]);
    }
    public function test_usuario_nao_autenticado_nao_pode_curtir_ou_descurtir_um_post()
    {
        // Cria um post
        $post = Post::factory()->create();

        // Tenta curtir sem autenticação
        $response = $this->postJson('/api/likes', [
            'postId' => $post->id,
        ]);

        //  Verifica não autorizado
        $response->assertStatus(401);

        // Tenta descurtir sem autenticação
        // Como a mesma rota trata curtir/descurtir, é o mesmo acima
        $response = $this->postJson('/api/likes', [
            'postId' => $post->id,
        ]);

        // Verifica não autorizado
        $response->assertStatus(401);
    }
    public function test_usuario_autenticado_pode_ver_todos_os_likes()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Cria likes
        $likes = Like::factory()->count(5)->create();

        // Envia requisição GET para recuperar likes
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/likes');

        // Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(5, 'data');
    }
    public function test_usuario_autenticado_pode_ver_um_like_especifico()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Cria um like
        $like = Like::factory()->create();

        // Envia requisição GET para ver um like específico
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/likes/{$like->id}");

        //  Verifica resposta
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'msg' => 'Curtida encontrada.',
                'data' => [
                    'id' => $like->id,
                    'postId' => $like->postId,
                    'userId' => $like->userId,
                ],
            ]);
    }
    public function test_ver_um_like_inexistente_retorna_erro()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Envia requisição GET para um like inexistente
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/likes/999'); // Supondo que o ID 999 não exista

        //  Verifica resposta
        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'msg' => 'Curtida não encontrada',
            ]);
    }
}
