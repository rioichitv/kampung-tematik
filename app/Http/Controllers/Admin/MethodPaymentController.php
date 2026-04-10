<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\MethodPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MethodPaymentController extends Controller
{
    protected array $types = ['qris', 'e-wallet', 'transfer-bank', 'virtual-account', 'convenience-store'];

    public function index()
    {
        $methods = MethodPayment::latest()->paginate(10);
        $edit = null;
        $gateway = Gateway::first();

        if (request()->filled('edit')) {
            $edit = MethodPayment::find(request('edit'));
        }

        return view('admin.methodpayments.index', [
            'methods' => $methods,
            'edit' => $edit,
            'types' => $this->types,
            'gateway' => $gateway,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storePublicImage($request->file('image'));
        }

        MethodPayment::create($data);

        return back()->with('success', 'Payment method berhasil ditambahkan.');
    }

    public function update(Request $request, MethodPayment $methodpayment)
    {
        $data = $this->validateData($request, $methodpayment->id);

        if ($request->hasFile('image')) {
            $newPath = $this->storePublicImage($request->file('image'));
            if ($methodpayment->image_path) {
                $this->deletePublicImage($methodpayment->image_path);
            }
            $data['image_path'] = $newPath;
        }

        $methodpayment->update($data);

        return redirect()->route('admin.methodpayments.index')->with('success', 'Payment method diperbarui.');
    }

    public function destroy(MethodPayment $methodpayment)
    {
        if ($methodpayment->image_path) {
            $this->deletePublicImage($methodpayment->image_path);
        }
        $methodpayment->delete();

        return back()->with('success', 'Payment method dihapus.');
    }

    public function updateCredentials(Request $request)
    {
        $validated = $request->validate([
            'merchant_id' => ['nullable', 'string', 'max:191'],
            'client_key' => ['nullable', 'string', 'max:191'],
            'server_key' => ['nullable', 'string', 'max:191'],
        ]);

        $gateway = Gateway::first() ?: new Gateway();
        $gateway->fill([
            'merchant_id' => $validated['merchant_id'],
            'client_key' => $validated['client_key'],
            'server_key' => $validated['server_key'],
        ])->save();

        return back()->with('success', 'Kredensial payment berhasil disimpan.');
    }

    protected function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:50', Rule::unique('methodpayment', 'code')->ignore($ignoreId)],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['required', Rule::in($this->types)],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    protected function storePublicImage($file): string
    {
        $dir = public_path('images/payment');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return 'images/payment/' . $filename;
    }

    protected function deletePublicImage(?string $path): void
    {
        if (! $path) {
            return;
        }
        $full = public_path($path);
        if (File::exists($full)) {
            File::delete($full);
        }
    }
}
