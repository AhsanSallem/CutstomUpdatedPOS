<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Product;
use App\Contact;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\CatalogEmail;

class CatalogController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param  ProductUtils  $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalog_type = request()->get('type');
        if ($catalog_type == 'product' && ! auth()->user()->can('catalog.view') && ! auth()->user()->can('catalog.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $can_edit = true;
            if ($catalog_type == 'product' && ! auth()->user()->can('catalog.update')) {
                $catalog_type = false;
            }

            $can_delete = true;
            if ($catalog_type == 'product' && ! auth()->user()->can('catalog.delete')) {
                $can_delete = false;
            }
            $can_download = true;
            if ($catalog_type == 'product' && ! auth()->user()->can('catalog.download')) {
                $can_download = false;
            }
            $send_whatsapp = true;
            if ($catalog_type == 'product' && ! auth()->user()->can('catalog.download')) {
                $send_whatsapp = false;
            }
            $send_email = true;
            if ($catalog_type == 'product' && ! auth()->user()->can('catalog.download')) {
                $send_email = false;
            }
            
            $can_addProducts = true;
            if ($can_addProducts == 'product' && ! auth()->user()->can('catalog.download')) {
                $can_addProducts = false;
            }
            $business_id = request()->session()->get('user.business_id');

            $catalog = Catalog::where('business_id', $business_id)
            ->select(['name', 'code', 'assign_to', 'id']);

            return Datatables::of($catalog)
            ->addColumn('action', function ($row) use ($can_edit, $can_delete,$can_download, $send_email, $send_whatsapp, $catalog_type,$can_addProducts) {
                $html = '';
                if ($can_edit) {
                    $html .= '<button data-href="'.action([\App\Http\Controllers\CatalogController::class, 'edit'], [$row->id]).'?type='.$catalog_type.'" class="btn btn-xs btn-primary edit_catalog_button"><i class="glyphicon glyphicon-edit"></i>'.__('messages.edit').'</button>';
                }
                if ($can_addProducts) {
                    $html .= '<a href="'.route('products.index', ['catalog_id' => $row->id]).'" class="btn btn-xs btn-primary" style="margin-left: 5px;"><i class="glyphicon glyphicon-plus"></i>'.__('Add Products').'</a>';
                }               
            
                if ($can_delete) {
                    $html .= '&nbsp;<button data-href="'.action([\App\Http\Controllers\CatalogController::class, 'destroy'], [$row->id]).'" class="btn btn-xs btn-danger delete_catalog_button"><i class="glyphicon glyphicon-trash"></i> '.__('messages.delete').'</button>';
                }
            
                if ($can_download) {
                    $html .= '&nbsp;<button data-href="'.action([\App\Http\Controllers\CatalogController::class, 'downloadCatalog'], [$row->id]).'" class="btn btn-xs btn-success download_catalog_button"><i class="glyphicon glyphicon-download-alt"></i> '.__('Download Catalog').'</button>';
                }
                if ($send_whatsapp) {
                    // $html .= '&nbsp;<button data-href="'.action([\App\Http\Controllers\CatalogController::class, 'send']).'" class="btn btn-xs btn-info send_button"><i class="fa fa-paper-plane"></i> '.__('Send via WhatsApp & Email').'</button>';

                    $html .= '&nbsp;<button data-href="'.action([\App\Http\Controllers\CatalogController::class, 'sendToWhatsApp'], [$row->id]).'" class="btn btn-xs btn-info send_whatsapp_button"><i class="fab fa-whatsapp"></i> '.__('Send via WhatsApp').'</button>';
                }
                if ($send_email) {
                    $html .= '&nbsp;<button data-href="' . action([\App\Http\Controllers\CatalogController::class, 'sendToEmail'], [$row->id]) . '" class="btn btn-xs btn-success download_catalog_button"><i class="fas fa-envelope-open-text"></i> ' . __('Send to Email') . '</button>';
                }
                

                return $html;
            })
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('code', function ($row) {
              
                return $row->code;
            })
            
            ->editColumn('products', function ($row) {
                return $row->products;
            })
            // ->editColumn('assign_to', function ($row) {
            //     return $row->assign_to;
            // })
                ->removeColumn('id')
                ->removeColumn('parent_id')
                ->rawColumns(['action'])
                ->make(true);
        }
        $module_catalog_data = $this->moduleUtil->getCatalogData($catalog_type);
        return view('catalogs.index')->with(compact('module_catalog_data', 'module_catalog_data'));
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendToWhatsApp($catalog_id)
    {
        // dd($catalog_id);
        $catalog_type = request()->get('type');
        $business_id = request()->session()->get('user.business_id');
        $customers = Contact::all();
        return view('catalogs.customer')
        ->with(compact('customers','catalog_id'));
    }
    public function submitWhatsapp(Request $request)
    {
        // dd($request);
       $pdf =  $this->downloadCatalog($request->catalog_id);
       // Destination email address
    $toEmail = 'ahishamullhaq1@gmail.com';

    // Send the email with the PDF attachment
    // Mail::to($email)
    // ->from('mtahirmansoor257@gmail.com', 'Your Name')
    // ->send(new SendCatalogEmail($pdf)); // Assuming you have a custom Mailable class

    Mail::to($toEmail)->send(new CatalogEmail($pdf));

    // Handle the response
    if (count(Mail::failures()) > 0) {
        // Failed to send the email
        // Handle the error
        // ...
    } else {
        // Email sent successfully
        // Handle the success
        // ...
    }
    }
   

public function submitWhatsappSend(Request $request)
{
   // use Twilio\Rest\Client;
    // Generate the PDF
    $pdf = $this->downloadCatalog($request->catalog_id);

    // WhatsApp configuration
    $accountSid = 'YOUR_TWILIO_ACCOUNT_SID';
    $authToken = 'YOUR_TWILIO_AUTH_TOKEN';
    $twilioNumber = 'YOUR_TWILIO_PHONE_NUMBER';
    $whatsappNumber = '+923066723908'; // The destination WhatsApp number

    // Create the Twilio client
    $twilio = new Client($accountSid, $authToken);

    // Send the PDF via WhatsApp
    $message = $twilio->messages
        ->create("whatsapp:$whatsappNumber", // Destination WhatsApp number
            [
                'from' => "whatsapp:$twilioNumber",
                'body' => 'Here is the PDF file:',
                'mediaUrl' => ['https://example.com/path/to/Menu-Plumb-Part-Glasgow.pdf'], // Replace with the actual URL of the generated PDF
            ]);

    // Handle the response
    if ($message->errorCode) {
        // Failed to send the message
        // Handle the error
        $error = $message->errorMessage;
        // ...
    } else {
        // Message sent successfully
        // Handle the success
        // ...
    }
}

    public function send()
    {
        $catalog_type = request()->get('type');
        $business_id = request()->session()->get('user.business_id');
        $customers = Contact::all();
        return view('catalogs.customer')
        ->with(compact('customers'));
    }
    // public function create()
    // {
    //     $catalog_type = request()->get('type');
    //     if ($catalog_type == 'product' && ! auth()->user()->can('catalog.create')) {
    //         abort(403, 'Unauthorized action.');
    //     }
        
    //     $business_id = request()->session()->get('user.business_id');
        
    //     $module_catalog_data = $this->moduleUtil->getCatalogData($catalog_type);
        
    //     // Get the products for the checkboxes
    //     $products = Product::where('business_id', $business_id)->get();

    //     return view('catalogs.create')
    //         ->with(compact('module_catalog_data', 'catalog_type', 'products'));
    // }
    public function sendToEmail($id)
{
    // Retrieve the catalog and perform necessary operations to send it via email
    // You can use the $id parameter to fetch the specific catalog
    
    // Example code to send the catalog via email
    $catalog = Catalog::findOrFail($id);
    $recipientEmail = "example@example.com";
    $subject = "Catalog: " . $catalog->name;
    $body = "Please find attached the catalog: " . $catalog->name;
    
    // Use your preferred method to send the email
    // This is just a placeholder/example
    // sendEmail($recipientEmail, $subject, $body, $catalog->pdf_path);
    
    // Redirect or return a response based on your needs
    return redirect()->back()->with('success', 'Catalog sent via email successfully.');
}


    
    public function downloadCatalog($id)
    {
        $business_id = request()->session()->get('user.business_id');
    
        $catalog = Catalog::where('business_id', $business_id)->findOrFail($id);
        $selectedProducts = json_decode($catalog->products, true);
        $products = Product::whereIn('id', $selectedProducts)->get();
        $blade_file = 'download_pdf';
    
        // Convert images to base64-encoded strings
        foreach ($products as &$product) {
            if (empty($product['image_url'])) {
                $imagePath = public_path('img/default.png');
            } else if (strpos($product['image_url'], 'http') === 0) {
                // Skip remote URLs
                continue;
            } else {
                $imagePath = public_path($product['image_url']);
            }
    
            if (!file_exists($imagePath)) {
                $imagePath = public_path('img/default.png');
            }
    
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageData = file_get_contents($imagePath);
            $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            $product['base64_image'] = $base64Image;
        }
    
        // Generate PDF
        $body = view('catalogs.catalogMenu')
                    ->with(compact('products'))
                    ->render();
        // echo $body;die;
      // Replace the image URLs with base64-encoded strings
$body = preg_replace_callback('/<img src="([^"]+)"/', function ($matches) {
    $imageSrc = $matches[1];
    if (strpos($imageSrc, 'http') === 0) {
        return $matches[0]; // Skip external images
    }

    $imagePath = public_path($imageSrc);
    if (!file_exists($imagePath)) {
        $imagePath = public_path('img/default.png');
    }

    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
    $imageData = file_get_contents($imagePath);
    $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);

    return str_replace($matches[1], $base64Image, $matches[0]);
}, $body);

    
        $mpdf = new \Mpdf\Mpdf(['tempDir' => public_path('uploads/temp'),
            'mode' => 'utf-8',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'autoVietnamese' => true,
            'autoArabic' => true,
            'margin_top' => 8,
            'margin_bottom' => 8,
            'format' => 'A4',
        ]);
        $mpdf->useSubstitutions = true;
        $mpdf->SetWatermarkText("Plumb-Part-Glasgow", 0.1);
        $mpdf->showWatermarkText = true;
        $mpdf->SetTitle('Menu-Plumb-Part-Glasgow.pdf');
        $mpdf->WriteHTML($body);
        $mpdf->Output('Menu-Plumb-Part-Glasgow.pdf', 'D');
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalog_type = request()->get('type');
        if ($catalog_type == 'product' && ! auth()->user()->can('catalog.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');
        
        $module_catalog_data = $this->moduleUtil->getCatalogData($catalog_type);
        
        // Get the products for the checkboxes
        $products = Product::where('business_id', $business_id)->get();

        return view('catalogs.create')
            ->with(compact('module_catalog_data', 'catalog_type', 'products'));
    }

    public function getcatalogsProductSearch(Request $request)
    {
        $searchTerm = $request->input('q'); // Get the search term from the request
        $products = Product::where('name', 'like', "%$searchTerm%")->get(); // Perform the product search based on the search term
        
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'text' => $product->name,
                'name' => $product->name,
                // Add any other relevant product information that you want to display in the dropdown
            ];
        }
        
        return response()->json($formattedProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catalog_type = $request->input('catalog_type');
        if ($catalog_type == 'product' && !auth()->user()->can('catalog.create')) {
            abort(403, 'Unauthorized action.');
        }
    
        try {
            $input = $request->only(['name', 'code', 'catalog_type']);
            $input['business_id'] = $request->session()->get('user.business_id');
            
            // Convert selected product IDs to JSON
            $products = $request->input('products', []);
            $input['products'] = json_encode($products);
    
            $catalog = Catalog::create($input);
    
            $output = [
                'success' => true,
                'data' => $catalog,
                'msg' => __('category.added_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
    
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }
    
        return $output;
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catalog_type = request()->get('type');
        if ($catalog_type == 'product' && !auth()->user()->can('category.update')) {
            abort(403, 'Unauthorized action.');
        }
    
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $catalog = Catalog::where('business_id', $business_id)->find($id);
            $products = Product::where('business_id', $business_id)->get();
            $selectedProducts = json_decode($catalog->products, true); // Decode the JSON string
            $module_catalog_data = $this->moduleUtil->getCatalogData($catalog_type);
    
            return view('catalogs.edit')
                ->with(compact('catalog', 'module_catalog_data', 'catalog_type', 'products', 'selectedProducts'));
        }
    }
    

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $catalog_type = $request->input('catalog_type');
        if ($catalog_type == 'product' && !auth()->user()->can('catalog.update')) {
            abort(403, 'Unauthorized action.');
        }
    
        try {
            $catalog = Catalog::findOrFail($id);
            $input = $request->only(['name', 'code', 'catalog_type']);
            $input['business_id'] = $request->session()->get('user.business_id');
    
            // Convert selected product IDs to JSON
            $products = $request->input('products', []);
            $input['products'] = json_encode($products);
    
            $catalog->update($input);
    
            $output = [
                'success' => true,
                'data' => $catalog,
                'msg' => __('category.updated_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
    
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }
    
        return $output;
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $catalog = Catalog::where('business_id', $business_id)->findOrFail($id);

                if ($catalog->catalog_type == 'product' && ! auth()->user()->can('catalog.delete')) {
                    abort(403, 'Unauthorized action.');
                }

                $catalog->delete();

                $output = ['success' => true,
                    'msg' => __('Catalog Deleted Success'),
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    public function getCategoriesApi()
    {
        try {
            $api_token = request()->header('API-TOKEN');

            $api_settings = $this->moduleUtil->getApiSettings($api_token);

            $categories = Category::catAndSubCategories($api_settings->business_id);
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            return $this->respondWentWrong($e);
        }

        return $this->respond($categories);
    }

    /**
     * get taxonomy index page
     * through ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function getcatalogsIndexPage(Request $request)
    {
        if (request()->ajax()) {
            $catalog_type = $request->get('catalog_type');
            $module_catalog_data = $this->moduleUtil->getCatalogData($catalog_type);

            return view('taxonomy.ajax_index')
                ->with(compact('module_catalog_data', 'catalog_type'));
        }
    }
}
