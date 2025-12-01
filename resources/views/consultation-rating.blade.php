<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Consultation - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Rate Consultation
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ $raterType === 'customer' ? 'Rate your consultant' : 'Rate your client' }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600 mb-1"><strong>Topic:</strong> {{ $consultation->topic }}</p>
                <p class="text-sm text-gray-600">
                    <strong>{{ $raterType === 'customer' ? 'Consultant' : 'Client' }}:</strong> 
                    {{ $raterType === 'customer' ? optional(optional($consultation->consultantProfile)->user)->name : $consultation->customer->name }}
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('consultation.rating.save', $consultation->id) }}" class="mt-8 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Rating *</label>
                    <div class="flex justify-center space-x-4">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" 
                                    class="hidden rating-input" 
                                    {{ old('rating', $existingRating->rating ?? '') == $i ? 'checked' : '' }} required>
                                <span class="text-4xl rating-star" data-rating="{{ $i }}">
                                    {{ $i === 1 ? '😟' : ($i === 2 ? '😐' : ($i === 3 ? '🙂' : ($i === 4 ? '😊' : '🤩'))) }}
                                </span>
                            </label>
                        @endfor
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-2">1 = Poor, 5 = Excellent</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                    <textarea name="comment" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Share your experience...">{{ old('comment', $existingRating->comment ?? '') }}</textarea>
                </div>

                <div class="flex space-x-3">
                    @if($raterType === 'customer')
                        <a href="{{ route('customer.my-consults') }}" class="flex-1 text-center px-4 py-2 border rounded hover:bg-gray-50">Cancel</a>
                    @else
                        <a href="{{ route('consultant.consultations') }}" class="flex-1 text-center px-4 py-2 border rounded hover:bg-gray-50">Cancel</a>
                    @endif
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Submit Rating
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-star');
            const inputs = document.querySelectorAll('.rating-input');

            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    highlightStars(rating);
                });

                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    inputs[index].checked = true;
                });
            });

            document.querySelector('.rating-input:checked')?.parentElement?.querySelector('.rating-star')?.classList.add('opacity-100', 'scale-110');

            function highlightStars(upTo) {
                stars.forEach((star, index) => {
                    if (index < upTo) {
                        star.classList.add('opacity-100', 'scale-110');
                    } else {
                        star.classList.remove('opacity-100', 'scale-110');
                    }
                });
            }

            document.querySelector('form').addEventListener('mouseleave', function() {
                const checked = document.querySelector('.rating-input:checked');
                if (checked) {
                    const rating = parseInt(checked.value);
                    highlightStars(rating);
                } else {
                    stars.forEach(star => {
                        star.classList.remove('opacity-100', 'scale-110');
                    });
                }
            });
        });
    </script>
</body>
</html>

