<?php namespace RealTours\ManageBookings\Components;

use Cms\Classes\ComponentBase;
use RealTours\Managebookings\Models\Bookings;
use RealTours\Managebookings\Models\Customers;
use RealTours\ManageBookings\Models\Tours;

use Flash;
use Input;
use Validator;
use ValidationException;

class BookingForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Booking Form',
            'description' => 'Displays a booking enquiry form'
        ];
    }

    public function defineProperties()
    {
        return [
            'tourSlug' => [
                'title'       => 'Tour Slug',
                'description' => 'The slug of the tour to book',
                'type'        => 'string',
                'default'     => '{{ :slug }}'
            ]
        ];
    }

    public function onRun()
    {
        $this->page['tour'] = Tours::where('slug', $this->property('tourSlug'))->first();
    }

    public function onSave()
    {
        $data = Input::all();

        // Validate customer data
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'booking_date' => 'required|date',
            'number_of_people' => 'required|integer|min:1'
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        // Get tour
        $tour = Tours::where('slug', $this->property('tourSlug'))->first();
        if (!$tour) {
            throw new ValidationException(['tour' => 'Tour not found']);
        }

        // Create or find customer
        $customer = Customers::firstOrCreate(
            ['email' => $data['email']],
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone']
            ]
        );

        // Calculate total amount
        $totalAmount = $tour->price * $data['number_of_people'];

        // Create booking
        $booking = new Bookings;
        $booking->customer_id = $customer->id;
        $booking->tour_id = $tour->id;
        $booking->booking_date = $data['booking_date'];
        $booking->number_of_people = $data['number_of_people'];
        $booking->special_requirements = $data['special_requirements'] ?? null;
        $booking->status = Bookings::STATUS_PENDING;
        $booking->payment_status = Bookings::PAYMENT_PENDING;
        $booking->total_amount = $totalAmount;
        $booking->save();

        Flash::success('Your booking request has been submitted successfully. We will contact you shortly.');

        return [
            '#booking-form' => $this->renderPartial('@success', ['booking' => $booking])
        ];
    }
}
