@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-blue-50">
        
        <div class="h-32 bg-gradient-to-r from-blue-700 via-blue-500 to-blue-400 relative">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        </div>

        <div class="p-8">
            
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight mb-2">{{ $profileData->name }}</h2>
                
                <div class="flex flex-col md:flex-row justify-center items-center gap-3 text-gray-500">
                    <div class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span class="font-medium">{{ $profileData->email }}</span>
                    </div>

                    <span class="hidden md:block text-gray-300">•</span>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider shadow-sm">
                        @if($profileData->role === 'student')
                            Học sinh
                        @elseif($profileData->role === 'teacher')
                            Giáo viên
                        @else
                            {{ ucfirst($profileData->role) }}
                        @endif
                    </span>
                </div>
            </div>


            <div class="mt-8 flex justify-center">
                <a href="{{ route('face.register') }}"
                   class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700">
                    Đăng ký khuôn mặt
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Logic cho HỌC SINH --}}
                @if($profileData->role === 'student' && $profileData->student)
                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Mã học sinh</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profileData->student->student_id }}</p>
                        </div>
                    </div>

                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Lớp học</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profileData->student->class->name ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>

                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Ngày sinh</p>
                            <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($profileData->student->day_of_birth)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Giới tính</p>
                            <p class="text-lg font-bold text-gray-800">{{ ucfirst($profileData->student->gender) }}</p>
                        </div>
                    </div>

                {{-- Logic cho GIÁO VIÊN --}}
                @elseif($profileData->role === 'teacher' && $profileData->teacher)
                    
                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Mã giáo viên</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profileData->teacher->teacher_id }}</p>
                        </div>
                    </div>

                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Bộ môn</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profileData->teacher->subject->name ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>

                    <div class="group flex items-center p-5 bg-blue-50/50 border border-blue-100 rounded-xl hover:bg-white hover:shadow-md hover:border-blue-200 transition-all duration-300 md:col-span-2 lg:col-span-1">
                        <div class="p-3 bg-white rounded-full text-blue-600 mr-4 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">Học hàm/Trình độ</p>
                            <p class="text-lg font-bold text-gray-800">{{ $profileData->teacher->level ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection