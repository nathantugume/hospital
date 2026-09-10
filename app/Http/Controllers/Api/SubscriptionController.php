<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\StoreRequest;
use App\Http\Requests\Subscriptions\UpdateRequest;
use App\Http\Resources\Subscription\Resource;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Subscription::class);

        $query = Subscription::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Per-page (default 15, max 100)
        $perPage = min((int) $request->input('per_page', 15), 100);

        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Subscription list retrieved.',
            'data' => Resource::collection($items->items()),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
            'links' => [
                'first' => $items->url(1),
                'last' => $items->url($items->lastPage()),
                'prev' => $items->previousPageUrl(),
                'next' => $items->nextPageUrl(),
            ],
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('create', Subscription::class);
        $data = $request->validated();
        if (empty($data['code']) && \Schema::hasColumn((new Subscription)->getTable(), 'code')) {
            $data['code'] = \Str::upper(\Str::snake(class_basename(Subscription::class))) . '-' . str_pad((string) (Subscription::max('id') + 1), 4, '0', STR_PAD_LEFT);
        }
        $item = Subscription::create($data);
        return $this->resource(new Resource($item), 'Subscription created.', 201);
    }

    public function show(Subscription $model_var): JsonResponse
    {
        $this->authorize('view', $model_var);
        return $this->resource(new Resource($model_var));
    }

    public function update(UpdateRequest $request, Subscription $model_var): JsonResponse
    {
        $this->authorize('update', $model_var);
        $model_var->update($request->validated());
        return $this->resource(new Resource($model_var), 'Subscription updated.');
    }

    public function destroy(Subscription $model_var): JsonResponse
    {
        $this->authorize('delete', $model_var);
        $model_var->delete();
        return response()->json(['success' => true, 'message' => 'Subscription deleted.'], 200);
    }
}
