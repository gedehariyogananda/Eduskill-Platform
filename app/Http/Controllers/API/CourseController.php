<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PaymentFailedNotifMail;
use App\Mail\PaymentPrivatCourse;
use App\Mail\PaymentSendMail;
use App\Mail\PaymentSuccessCustomerToAdminMail;
use App\Mail\PaymentSuccessMail;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\PacketClass;
use App\Models\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Xendit\PaymentMethod\PaymentMethod;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['onlineCourse', 'onlineCourseDetail', 'privatCourse', 'privatCourseDetail', 'allOnlineCourse', 'allPrivatCourse', 'courseSpesify', 'buyCourse', 'courseUser', 'callbackNotif', 'buyCoursePrivat']]);
        Configuration::setXenditKey(env('XENDID_API_KEY'));
    }

    public function onlineCourse()
    {
        $onlineCourseLimit3 = Course::where('category_course', 'Online Course')->where('status_course', 'published')->limit(3)->get();
        if ($onlineCourseLimit3->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Online Course Not Found',
            ]);
        }

        $mappedDataCourse = $onlineCourseLimit3->map(function ($item) {
            $priceCourseFormat = number_format($item->price_course, 0, ',', '.');
            $priceDiscountCourseFormat = number_format($item->price_discount_course, 0, ',', '.');
            if ($item->is_free_course == 1) {
                $isFree = true;
            } else {
                $isFree = false;
            }
            return [
                'id' => $item->id,
                'name_course' => $item->name_course,
                'slug_course' => $item->slug_course,
                'banner_course' => $item->banner_course,
                'instructor_course' => $item->instructor_course,
                'experiences_instructor_course' => $item->experiences_instructor_course,
                'description_course' => $item->description_course,
                'category_course' => $item->category_course,
                'price_course' => $priceCourseFormat,
                'price_discount_course' => $priceDiscountCourseFormat,
                'is_free_course' => $isFree,
                'created_at' => $item->created_at->format('d F Y'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Online Course limit 3',
            'data' => $mappedDataCourse
        ]);
    }

    public function privatCourse()
    {
        $privatCourseLimit3 = Course::where('category_course', 'Private Course')->where('status_course', 'published')->limit(3)->get();
        if ($privatCourseLimit3->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Private Course Not Found',
            ]);
        }

        $mappedDataCourse = $privatCourseLimit3->map(function ($item) {
            return [
                'id' => $item->id,
                'name_course' => $item->name_course,
                'slug_course' => $item->slug_course,
                'banner_course' => $item->banner_course,
                'description_course' => $item->description_course,
                'category_course' => $item->category_course,
                'instructor_course' => $item->instructor_course,
                'experiences_instructor_course' => $item->experiences_instructor_course,
                'created_at' => $item->created_at->format('d F Y'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Private Course limit 3',
            'data' => $mappedDataCourse
        ]);
    }

    public function allOnlineCourse()
    {
        $onlineCourse = Course::where('category_course', 'Online Course')->where('status_course', 'published')->get();
        if ($onlineCourse->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Online Course Not Found',
            ]);
        }

        $mappedDataCourse = $onlineCourse->map(function ($item) {
            $priceCourseFormat = number_format($item->price_course, 0, ',', '.');
            $priceDiscountCourseFormat = number_format($item->price_discount_course, 0, ',', '.');
            if ($item->is_free_course == 1) {
                $isFree = true;
            } else {
                $isFree = false;
            }
            return [
                'id' => $item->id,
                'name_course' => $item->name_course,
                'slug_course' => $item->slug_course,
                'banner_course' => $item->banner_course,
                'instructor_course' => $item->instructor_course,
                'experiences_instructor_course' => $item->experiences_instructor_course,
                'description_course' => $item->description_course,
                'category_course' => $item->category_course,
                'price_course' => $priceCourseFormat,
                'price_discount_course' => $priceDiscountCourseFormat,
                'is_free_course' => $isFree,
                'created_at' => $item->created_at->format('d F Y'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Online Course',
            'data' => $mappedDataCourse
        ]);
    }

    public function allPrivatCourse()
    {
        $privatCourse = Course::where('category_course', 'Private Course')->where('status_course', 'published')->get();
        if ($privatCourse->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Private Course Not Found',
            ]);
        }

        $mappedDataCourse = $privatCourse->map(function ($item) {
            return [
                'id' => $item->id,
                'name_course' => $item->name_course,
                'slug_course' => $item->slug_course,
                'banner_course' => $item->banner_course,
                'description_course' => $item->description_course,
                'category_course' => $item->category_course,
                'instructor_course' => $item->instructor_course,
                'experiences_instructor_course' => $item->experiences_instructor_course,
                'created_at' => $item->created_at->format('d F Y'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Private Course',
            'data' => $mappedDataCourse
        ]);
    }

    public function courseSpesify($slug)
    {
        try {
            $theCourse = Course::with('course_details')->where('slug_course', $slug)->first();

            if ($theCourse->status_course == "unpublished" || $theCourse->status_course == "archived") {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Course Not Found',
                ], 404);
            }

            if ($theCourse->category_course == "Online Course") {
                $priceCourseFormat = number_format($theCourse->price_course, 0, ',', '.');
                $priceDiscountCourseFormat = number_format($theCourse->price_discount_course, 0, ',', '.');
                $isFree = $theCourse->is_free_course == 1;

                $isAuthenticate = false;
                $status = 'lock';
                $urlPayment = null;
                try {
                    if ($user = JWTAuth::parseToken()->authenticate()) {
                        $isAuthenticate = true;
                        $courseUser = $theCourse->course_users->where('user_id', $user->id)->first();
                        if ($courseUser) {
                            $status = 'unlock';
                        } else {
                            $status = 'lock';
                        }
                    } else {
                        $isAuthenticate = false;
                    }
                } catch (\Exception $e) {
                    $status = 'lock';
                }

                if ($status == 'lock') {
                    $joinClass = true;
                } else {
                    $joinClass = false;
                }

                $checkPayment = PaymentGateway::where('user_id', $user->id)->where('course_id', $theCourse->id)->first();
                if ($checkPayment) {
                    if ($checkPayment->payment_status == 'pending') {
                        $urlPayment = $checkPayment->url_payment;
                    }
                }

                $mappedDataCourse = [
                    'id' => $theCourse->id,
                    'name_course' => $theCourse->name_course,
                    'slug_course' => $theCourse->slug_course,
                    'banner_course' => $theCourse->banner_course,
                    'instructor_course' => $theCourse->instructor_course,
                    'experiences_instructor_course' => $theCourse->experiences_instructor_course,
                    'description_course' => $theCourse->description_course,
                    'category_course' => $theCourse->category_course,
                    'price_course' => $priceCourseFormat,
                    'price_discount_course' => $priceDiscountCourseFormat,
                    'is_free_course' => $isFree,
                    'created_at' => $theCourse->created_at->format('d F Y'),
                    'join_class' => $joinClass,
                    'is_authenticate' => $isAuthenticate,
                    'url_payment' => $urlPayment,
                    'videos_course' => $theCourse->course_details->map(function ($item) use ($status) {
                        return [
                            'id' => $item->id,
                            'title_course' => $item->title_course,
                            'slug_course' => $item->slug_course,
                            'duration_course' => $item->duration_course,
                            'url_video_course' => $item->url_video_course,
                            'transkrip_course' => $item->transkrip_course,
                            'status_course_detail' => $status,
                        ];
                    }),
                ];

                return response()->json([
                    'success' => true,
                    'message' => 'Data Spesify Online Course',
                    'data' => $mappedDataCourse
                ]);
            }

            if ($theCourse->category_course == "Private Course") {
                $urlPayment = null;
                $isAuthenticate = false;

                if ($user = JWTAuth::parseToken()->authenticate()) {
                    $isAuthenticate = true;
                } else {
                    $isAuthenticate = false;
                }

                $checkPayment = PaymentGateway::where('user_id', $user->id)->where('course_id', $theCourse->id)->first();
                if ($checkPayment) {
                    if ($checkPayment->payment_status == 'pending') {
                        $urlPayment = $checkPayment->url_payment;
                    }
                }


                $packet_class = PacketClass::all();
                $mappedDataCourse = [
                    'id' => $theCourse->id,
                    'name_course' => $theCourse->name_course,
                    'slug_course' => $theCourse->slug_course,
                    'banner_course' => $theCourse->banner_course,
                    'description_course' => $theCourse->description_course,
                    'category_course' => $theCourse->category_course,
                    'instructor_course' => $theCourse->instructor_course,
                    'experiences_instructor_course' => $theCourse->experiences_instructor_course,
                    'is_authenticate' => $isAuthenticate,
                    'url_payment' => $urlPayment,
                    'created_at' => $theCourse->created_at->format('d F Y'),
                    'packet_classes' => $packet_class,
                ];

                return response()->json([
                    'success' => true,
                    'message' => 'Data Spesify Private Course',
                    'data' => $mappedDataCourse
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //  ------------------------- xendid payment gateway setup ---------------------- //

    public function buyCourse($course)
    {
        $theCourse = Course::where('slug_course', $course)->first();

        if (!$theCourse) {
            return response()->json([
                'success' => false,
                'message' => 'Data Course Not Found',
            ]);
        }

        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                $courseUser = $theCourse->course_users->where('user_id', $user->id)->first();
                if ($courseUser) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User Already Join This Course',
                    ]);
                }

                if ($theCourse->is_free_course == true) {
                    $theCourse->course_users()->create([
                        'user_id' => $user->id,
                        'status_course' => 'unlock',
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'User Success Join This Course',
                    ]);
                }

                $paymentInit = PaymentGateway::where('user_id', $user->id)->where('course_id', $theCourse->id)->first();

                if ($paymentInit) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User Already Payment This Course',
                    ]);
                }

                // -- ini jika berbayar maka payment gateway -- //
                $externalId = 'Invoices - ' . rand();
                $paymentInit = PaymentGateway::create([
                    'external_id' => $externalId,
                    'user_id' => $user->id,
                    'course_id' => $theCourse->id,
                    'payment_method' => null,
                    'amount_payment' => $theCourse->price_discount_course,
                ]);

                $createInvoices = new CreateInvoiceRequest([
                    'external_id' => $paymentInit->external_id,
                    'amount' => $theCourse->price_discount_course,
                    // Durasi pembayaran 1 hari (24 jam * 60 menit * 60 detik)
                    'invoice_duration' => 86400,
                ]);

                $apiXendid = new InvoiceApi();
                $response = $apiXendid->createInvoice($createInvoices);
                $saveUrl = $response['invoice_url'];

                $updatePaymentGateway = PaymentGateway::where('id', $paymentInit->id)->update([
                    'url_payment' => $saveUrl,
                ]);

                if ($updatePaymentGateway) {
                    $theDataMethodPayment = PaymentGateway::where('id', $paymentInit->id)->first();

                    $urlPembayaran = $theDataMethodPayment->url_payment;
                    $priceCourseFormat = number_format($theDataMethodPayment->amount_payment, 0, ',', '.');
                    // notif via email
                    Mail::to($user->email)->send(new PaymentSendMail($urlPembayaran, $priceCourseFormat, $theCourse->name_course));

                    return response()->json([
                        'success' => true,
                        'message' => 'Payment Success Created',
                        'data' => [
                            'url_payment' => $theDataMethodPayment->url_payment,
                        ]
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Payment Failed Created',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User Must Login First',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function buyCoursePrivat($course, $idClasses)
    {
        $theCourse = Course::where('slug_course', $course)->first();
        $packetClass = PacketClass::where('id', $idClasses)->first();

        if (!$theCourse) {
            return response()->json([
                'success' => false,
                'message' => 'Data Course Not Found',
            ]);
        }

        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                // $courseUser = $theCourse->course_users->where('user_id', $user->id)->first();
                // if ($courseUser) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'User Already Join This Course',
                //     ]);
                // }

                $paymentInit = PaymentGateway::where('user_id', $user->id)->where('course_id', $theCourse->id)->first();

                if ($paymentInit) {
                    if ($paymentInit->payment_status != "success") {
                        return response()->json([
                            'success' => false,
                            'message' => 'selesaikan pembayaran sebelumnya terlebih dahulu, silahkan cek email atau ditampilan course',
                        ], 200);
                    }

                    // -- ini jika berbayar maka payment gateway -- //
                    $externalId = 'Invoices - ' . rand();

                    $paymentInit = PaymentGateway::create([
                        'external_id' => $externalId,
                        'user_id' => $user->id,
                        'course_id' => $theCourse->id,
                        'payment_method' => null,
                        'amount_payment' => intval($packetClass->price_packet_class),
                    ]);

                    $createInvoices = new CreateInvoiceRequest([
                        'external_id' => $paymentInit->external_id,
                        'amount' => intval($packetClass->price_packet_class),
                        // Durasi pembayaran 1 hari (24 jam * 60 menit * 60 detik)
                        'invoice_duration' => 86400,
                    ]);

                    $apiXendid = new InvoiceApi();
                    $response = $apiXendid->createInvoice($createInvoices);
                    $saveUrl = $response['invoice_url'];


                    $updatePaymentGateway = PaymentGateway::where('id', $paymentInit->id)->update([
                        'url_payment' => $saveUrl,
                    ]);

                    if ($updatePaymentGateway) {

                        CourseUser::create([
                            'course_id' => $theCourse->id,
                            'user_id' => $user->id,
                            'status_course' => 'lock',
                            'packet_class_id' => $packetClass->id,

                        ]);


                        $theDataMethodPayment = PaymentGateway::where('id', $paymentInit->id)->first();

                        $urlPembayaran = $theDataMethodPayment->url_payment;
                        $priceCourseFormat = number_format($theDataMethodPayment->amount_payment, 0, ',', '.');
                        // notif via email
                        Mail::to($user->email)->send(new PaymentSendMail($urlPembayaran, $priceCourseFormat, $theCourse->name_course));

                        return response()->json([
                            'success' => true,
                            'message' => 'Payment Success Created',
                            'data' => [
                                'url_payment' => $theDataMethodPayment->url_payment,
                            ]
                        ]);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'Payment Failed Created',
                    ]);
                }

                // -- ini jika berbayar maka payment gateway -- //
                $externalId = 'Invoices - ' . rand();

                $paymentInit = PaymentGateway::create([
                    'external_id' => $externalId,
                    'user_id' => $user->id,
                    'course_id' => $theCourse->id,
                    'payment_method' => null,
                    'amount_payment' => intval($packetClass->price_packet_class),
                ]);

                $createInvoices = new CreateInvoiceRequest([
                    'external_id' => $paymentInit->external_id,
                    'amount' => intval($packetClass->price_packet_class),
                    // Durasi pembayaran 1 hari (24 jam * 60 menit * 60 detik)
                    'invoice_duration' => 86400,
                ]);

                $apiXendid = new InvoiceApi();
                $response = $apiXendid->createInvoice($createInvoices);
                $saveUrl = $response['invoice_url'];


                $updatePaymentGateway = PaymentGateway::where('id', $paymentInit->id)->update([
                    'url_payment' => $saveUrl,
                ]);

                if ($updatePaymentGateway) {

                    CourseUser::create([
                        'course_id' => $theCourse->id,
                        'user_id' => $user->id,
                        'status_course' => 'lock',
                        'packet_class_id' => $packetClass->id,
                    ]);

                    $theDataMethodPayment = PaymentGateway::where('id', $paymentInit->id)->first();

                    $urlPembayaran = $theDataMethodPayment->url_payment;
                    $priceCourseFormat = number_format($theDataMethodPayment->amount_payment, 0, ',', '.');
                    // notif via email
                    Mail::to($user->email)->send(new PaymentSendMail($urlPembayaran, $priceCourseFormat, $theCourse->name_course));

                    return response()->json([
                        'success' => true,
                        'message' => 'Payment Success Created',
                        'data' => [
                            'url_payment' => $theDataMethodPayment->url_payment,
                        ]
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Payment Failed Created',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function courseUser()
    {
        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                $courseUser = $user->courseUsers->where('status_course', 'unlock');
                if ($courseUser->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User Not Join Any Course',
                    ]);
                }

                $mappedDataCourse = $courseUser->map(function ($item) {
                    return [
                        'id' => $item->course->id,
                        'name_course' => $item->course->name_course,
                        'slug_course' => $item->course->slug_course,
                        'banner_course' => $item->course->banner_course,
                        'description_course' => $item->course->description_course,
                        'category_course' => $item->course->category_course,
                        'instructor_course' => $item->course->instructor_course,
                        'packet_courses' => $item->packet_class ? $item->packet_class->name_packet_class : null,
                        'experiences_instructor_course' => $item->course->experiences_instructor_course,
                        'created_at' => $item->course->created_at->format('d F Y'),
                    ];
                });

                return response()->json([
                    'success' => true,
                    'message' => 'List Data Course User',
                    'data' => $mappedDataCourse
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'User Must Login First',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function callbackNotif(Request $request)
    {
        $getTokenCallback = $request->headers->get('x-callback-token');
        $callbackTokenXendid = env('XENDID_CALLBACK_TOKEN');

        try {
            $checkPaymentExternalID = PaymentGateway::where('external_id', $request->external_id)->first();
            $nameCustomer = $checkPaymentExternalID->user->name;
            $mailCustomer = $checkPaymentExternalID->user->email;
            $emailCustomer = $checkPaymentExternalID->user->email;
            $noTelpCustomer = $checkPaymentExternalID->user->phone_number;
            $formatAmountPayment = number_format($checkPaymentExternalID->amount_payment, 0, ',', '.');
            $initCourse = $checkPaymentExternalID->course->category_course;
            $mailAdminEduskill = env('MAIL_USERNAME');

            if (!$callbackTokenXendid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Callback Xendid Not Found',
                ], 404);
            }
            if ($getTokenCallback != $callbackTokenXendid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Callback Not Valid',
                ], 404);
            }

            if ($checkPaymentExternalID) {

                if ($request->status == 'PAID') {

                    PaymentGateway::where('external_id', $request->external_id)->update([
                        'payment_status' => "success",
                        'payment_method' => $request->payment_method,
                    ]);

                    if ($initCourse == "Private Course") {

                        CourseUser::where('course_id', $checkPaymentExternalID->course_id)->where('user_id', $checkPaymentExternalID->user_id)->update([
                            'status_course' => 'unlock',
                        ]);

                        Mail::to($mailCustomer)->send(new PaymentPrivatCourse($formatAmountPayment, $checkPaymentExternalID->course->name_course));
                        // notif untuk admin mail kalau ada customer baru 
                        Mail::to($mailAdminEduskill)->send(new PaymentSuccessCustomerToAdminMail($formatAmountPayment, $checkPaymentExternalID->course->name_course, $nameCustomer, $initCourse, $emailCustomer, $noTelpCustomer));

                        return response()->json([
                            'success' => true,
                            'message' => 'Callback Notif Xendit Success Updated',
                        ], 200);
                    }

                    if ($initCourse == "Online Course") {

                        CourseUser::create([
                            'course_id' => $checkPaymentExternalID->course_id,
                            'user_id' => $checkPaymentExternalID->user_id,
                            'status_course' => 'unlock',
                        ]);
                        // notif via email customer success terbayarkan 
                        Mail::to($mailCustomer)->send(new PaymentSuccessMail($formatAmountPayment, $checkPaymentExternalID->course->name_course));

                        // notif untuk admin mail kalau ada customer baru 
                        Mail::to($mailAdminEduskill)->send(new PaymentSuccessCustomerToAdminMail($formatAmountPayment, $checkPaymentExternalID->course->name_course, $nameCustomer, $initCourse, $emailCustomer, $noTelpCustomer));

                        return response()->json([
                            'success' => true,
                            'message' => 'Callback Notif Xendit Success Updated',
                        ], 200);
                    }
                } else {

                    Mail::to($mailCustomer)->send(new PaymentFailedNotifMail($formatAmountPayment, $checkPaymentExternalID->course->name_course));
                    $checkPaymentExternalID->delete();

                    return response()->json([
                        'success' => false,
                        'message' => 'Callback Notif Xendit Failed Updated',
                    ], 200);
                }
            }
        } catch (Exception $e) {
            Log::error('Callback Notif Xendit: ' . $e->getMessage());
        }
    }
}
