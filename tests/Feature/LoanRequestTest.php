<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoanRequestTest extends TestCase
{
    private $endpoint = 'api/loans';
    
    public function testNotAuthLoanRequest()
    {
        $this->json('POST', $this->endpoint, ['Accept' => 'application/json'])
            ->assertStatus(401);
    }


    public function testRequiredFieldsForLoanRequest()
    {
        $this->actingAs();
        $this->json('POST', $this->endpoint, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "loan_amount" => ["The loan amount field is required."],
                    "loan_term" => ["The loan term field is required."],
                ]
            ]);
    }

    public function testNumericFieldsForLoanRequest()
    {
        $params = [
            "loan_term" => "foo",
            "loan_amount" => "bar"
        ];
        $this->actingAs();
        $this->json('POST', $this->endpoint, $params, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "loan_amount" => ["The loan amount must be a number."],
                    "loan_term" => ["The loan term must be a number."],
                ]
        ]);
    }

    public function testSuccessfulLoanRequest()
    {
        $params = [
            "loan_term" => "10",
            "loan_amount" => "1000",
        ];
        $this->actingAs();
        $this->json('POST', $this->endpoint, $params, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'attributes' => [
                        'user_id',
                        'principal_amount',
                        'status',
                        'loan_term',
                        'approved_at',
                        'disbursed_at',
                        'closed_at'
                    ]                    
                ],
                "message"
            ]);            
    }
}