<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="LSP UGM API Documentation",
 *     version="1.0.0",
 *     description="API Documentation for LSP UGM Application",
 *     @OA\Contact(
 *         email="admin@lsp-ugm.com",
 *         name="Administrator"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="LSP UGM API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     in="header",
 *     name="API_KEY"
 * )
 * 
 * @OA\ExternalDocumentation(
 *     description="Panduan Penggunaan API",
 *     url="https://lsp-ugm.com/api-docs"
 * )
 * 
 * @OA\Schema(
 *     schema="FileUpload",
 *     description="File upload schema untuk tanda tangan dan foto",
 *     @OA\Property(
 *         property="file",
 *         description="File yang akan diupload",
 *         type="string",
 *         format="binary"
 *     )
 * )
 */
class SwaggerController extends Controller
{
    public function index()
    {
        $documentation = 'default';
        
        $urlToDocs = route('l5-swagger.'.$documentation.'.docs', ['jsonFile' => config('l5-swagger.documentations.'.$documentation.'.paths.docs_json')]);
        
        // Set nilai default untuk variabel lain yang diperlukan view
        $operationsSorter = config('l5-swagger.defaults.operations_sort');
        $configUrl = config('l5-swagger.defaults.additional_config_url');
        $validatorUrl = config('l5-swagger.defaults.validator_url');
        $useAbsolutePath = config('l5-swagger.documentations.default.paths.use_absolute_path', true);
        
        return view('vendor.l5-swagger.index', compact(
            'documentation',
            'urlToDocs',
            'operationsSorter',
            'configUrl',
            'validatorUrl',
            'useAbsolutePath'
        ));
    }
}
