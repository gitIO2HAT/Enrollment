<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Course;
use App\Models\Major;

class CollegeController extends Controller
{
    public function college(Request $request)
    {
        // Check if the user is authenticated and has the correct user type
        if (Auth::check() && Auth::user()->user_type == 0) {
            // Fetch colleges, courses, and majors that are not deleted
            $colleges = College::where('deleted', '1')->get();
            $courses = Course::where('deleted', '1')->get();
            $majors = Major::where('deleted', '1')->get();
    
            // Get the selected college ID from the form, if it exists
            $selectedID = $request->input('selectedID', null); // Defaults to null if not set
    
            // Log the selectedID
            Log::info('Selected College ID:', ['selectedID' => $selectedID]);
    
            // Pass the data to the view
            return view('superadmin.college', [
                'colleges' => $colleges,
                'courses' => $courses,
                'majors' => $majors,
                'selectedID' => $selectedID, // This will be null if not present
            ]);
        }
    
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }




    public function addcollege(Request $request)
    {
        // Log the incoming request data
        Log::info('Add College Request:', $request->all());

        // Validation



        // Maximum allowed lengths for college name and description
        $maxCollegeLength = 10; // Adjust as needed for college name
        $maxDescriptionLength = 100; // Adjust as needed for description

        // Check if the college name exceeds the maximum length
        if (strlen($request->college) > $maxCollegeLength) {
            // Log that the college name is too long
            Log::warning('College name exceeds maximum length:', ['college' => $request->college]);

            return redirect()->back()->with('error', 'The college name must not exceed ' . $maxCollegeLength . ' characters.');
        }

        // Check if the description exceeds the maximum length
        if (strlen($request->description) > $maxDescriptionLength) {
            // Log that the description is too long
            Log::warning('Description exceeds maximum length:', ['description' => $request->description]);

            // Redirect back with an error message for description length
            return redirect()->back()->with('error', 'The description must not exceed ' . $maxDescriptionLength . ' characters.');
        }

        // Check if the college already exists in the database
        if (College::where('college', $request->college)->exists()) {
            // Log that the college already exists
            Log::warning('College already exists:', ['college' => $request->college]);

            // Redirect back with an error message for existence

            return redirect()->back()->with('error', 'College already Exist!');
        }

        // Continue with the rest of the code for adding the college

        // Log before creating the college
        Log::info('Creating a new College record.');

        $college = new College;
        $college->college = $request->college;
        $college->description = $request->description; // Ensure this line exists

        // Log the college data before saving
        Log::info('College Data:', [
            'college' => $college->college,
            'description' => $college->description,
        ]);

        $college->save();

        // Log successful save
        Log::info('College successfully added.');

        return redirect()->back()->with('success', 'College successfully added');
    }

    public function addcourse(Request $request)
    {
        // Check if the course name is null
        if (is_null($request->course)) {
            // Log that the course name is missing
            Log::warning('Course name is null');

            // Redirect back with an error message for missing course name
            return redirect()->back()->with(['error' => 'The course name cannot be null.']);
        }

        // Maximum allowed length for the course name
        $maxCourseLength = 100;

        // Check if the course name exceeds the maximum length
        if (strlen($request->course) > $maxCourseLength) {
            // Log that the course name is too long
            Log::warning('Course name exceeds maximum length:', ['course' => $request->course]);

            // Redirect back with an error message for course length
            return redirect()->back()->with(['error' => 'The course name must not exceed ' . $maxCourseLength . ' characters.']);
        }

        // Check if the course name already exists
        if (Course::where('course', $request->course)->exists()) {
            // Log that the course already exists
            Log::warning('Course name already exists:', ['course' => $request->course]);

            // Redirect back with an error message for uniqueness
            return redirect()->back()->with(['error' => 'This course name has already been taken.']);
        }

        // Check if the college exists
        if (!College::where('id', $request->college_id)->exists()) {
            // Log that the college ID is invalid
            Log::warning('Invalid college ID:', ['college_id' => $request->college_id]);

            // Redirect back with an error message for invalid college ID
            return redirect()->back()->with(['error' => 'The selected college is invalid.']);
        }

        // If all checks pass, proceed to create the course
        $course = new Course;
        $course->course = $request->course;
        $course->college_id = $request->college_id;

        // Save the course to the database
        $course->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Course successfully added');
    }



    public function addmajor(Request $request)
    {
        // Maximum allowed length for the major name
        $maxMajorLength = 50;

        // Check if the major name exceeds the maximum length
        if (strlen($request->major) > $maxMajorLength) {
            // Log that the major name is too long
            Log::warning('Major name exceeds maximum length:', ['major' => $request->major]);

            // Redirect back with an error message for major length
            return redirect()->back()->with(['error' => 'The major name must not exceed ' . $maxMajorLength . ' characters.']);
        }

        // Check if the major name already exists
        if (Major::where('major', $request->major)->exists()) {
            // Log that the major name already exists
            Log::warning('Major name already exists:', ['major' => $request->major]);

            // Redirect back with an error message for uniqueness
            return redirect()->back()->with(['error' => 'This major name has already been taken.']);
        }

        // Check if the course exists
        if (!Course::where('id', $request->course_id)->exists()) {
            // Log that the course ID is invalid
            Log::warning('Invalid course ID:', ['course_id' => $request->course_id]);

            // Redirect back with an error message for invalid course ID
            return redirect()->back()->with(['error' => 'The selected course is invalid.']);
        }

        // If all checks pass, proceed to create the major
        $major = new Major;
        $major->major = $request->major;
        $major->course_id = $request->course_id;

        // Save the major to the database
        $major->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Major successfully added');
    }


    public function editcollege($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit College Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);

        // Retrieve the college record
        $college = College::find($id);
        if (!$college) {
            Log::error('College not found with ID: ' . $id);
            return redirect()->back()->with('error', 'College not found');
        }

        // Maximum lengths for the fields
        $maxCollegeLength = 50;
        $maxDescriptionLength = 255;

        // Check college name length and uniqueness
        if ($request->college !== null) {
            if (strlen($request->college) > $maxCollegeLength) {
                // Log that the college name exceeds max length
                Log::warning('College name exceeds maximum length:', ['college' => $request->college]);
                return redirect()->back()->with(['error' => 'The college name must not exceed ' . $maxCollegeLength . ' characters.']);
            }

            if (College::where('college', $request->college)->where('id', '!=', $id)->exists()) {
                // Log that the college name is already taken
                Log::warning('College name already exists:', ['college' => $request->college]);
                return redirect()->back()->with(['error' => 'This college name has already been taken.']);
            }
        }

        // Check description length
        if ($request->description !== null && strlen($request->description) > $maxDescriptionLength) {
            // Log that the description exceeds max length
            Log::warning('Description exceeds maximum length:', ['description' => $request->description]);
            return redirect()->back()->with(['error' => 'The description must not exceed ' . $maxDescriptionLength . ' characters.']);
        }

        // Log current state of the college record
        Log::info('Current College Record:', [
            'college' => $college
        ]);

        // Update the college record
        $college->college = $request->college;
        $college->description = $request->description;

        // Log updated values before saving
        Log::info('Updating College Record:', [
            'college' => $college
        ]);

        // Save the updated college record
        $college->save();

        // Log success message
        Log::info('College successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'College successfully updated');
    }

    public function editcourse($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit Course Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);

        // Retrieve the course record
        $course = Course::find($id);
        if (!$course) {
            Log::error('Course not found with ID: ' . $id);
            return redirect()->back()->with('error', 'Course not found');
        }

        // Maximum length for the course name
        $maxCourseLength = 100;

        // Check if the course name is provided
        if ($request->course !== null) {
            // Validate course name length
            if (strlen($request->course) > $maxCourseLength) {
                // Log that the course name exceeds max length
                Log::warning('Course name exceeds maximum length:', ['course' => $request->course]);
                return redirect()->back()->with(['error' => 'The course name must not exceed ' . $maxCourseLength . ' characters.']);
            }

            // Check if the course name is unique
            if (Course::where('course', $request->course)->where('id', '!=', $id)->exists()) {
                // Log that the course name is already taken
                Log::warning('Course name already exists:', ['course' => $request->course]);
                return redirect()->back()->with(['error' => 'This course name has already been taken.']);
            }
        }

        // Log current state of the course record
        Log::info('Current Course Record:', [
            'course' => $course
        ]);

        // Update the course record
        $course->course = $request->course;

        // Log updated values before saving
        Log::info('Updating Course Record:', [
            'course' => $course
        ]);

        // Save the updated course record
        $course->save();

        // Log success message
        Log::info('Course successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'Course successfully updated');
    }


    public function editmajor($id, Request $request)
    {
        // Log incoming request data
        Log::info('Edit Major Request Data:', [
            'id' => $id,
            'request' => $request->all()
        ]);

        // Retrieve the major record
        $major = Major::find($id);
        if (!$major) {
            Log::error('Major not found with ID: ' . $id);
            return redirect()->back()->with('error', 'Major not found');
        }

        // Maximum length for the major name
        $maxMajorLength = 100;

        // Check if the major name is provided
        if ($request->major !== null) {
            // Validate major name length
            if (strlen($request->major) > $maxMajorLength) {
                // Log that the major name exceeds max length
                Log::warning('Major name exceeds maximum length:', ['major' => $request->major]);
                return redirect()->back()->with(['error' => 'The major name must not exceed ' . $maxMajorLength . ' characters.']);
            }

            // Check if the major name is unique
            if (Major::where('major', $request->major)->where('id', '!=', $id)->exists()) {
                // Log that the major name is already taken
                Log::warning('Major name already exists:', ['major' => $request->major]);
                return redirect()->back()->with(['error' => 'This major name has already been taken.']);
            }
        }

        // Log current state of the major record
        Log::info('Current Major Record:', [
            'major' => $major
        ]);

        // Update the major record
        $major->major = $request->major;

        // Log updated values before saving
        Log::info('Updating Major Record:', [
            'major' => $major
        ]);

        // Save the updated major record
        $major->save();

        // Log success message
        Log::info('Major successfully updated with ID: ' . $id);
        return redirect()->back()->with('success', 'Major successfully updated');
    }


    public function deletecollege($id)
    {
        $college = College::getId($id);

        $college->deleted = 2;
        $college->save();
        return redirect()->back()->with('success', 'College successfully DELETED');
    }
    public function deletecourse($id)
    {
        $course = Course::getId($id);

        $course->deleted = 2;
        $course->save();
        return redirect()->back()->with('success', 'Course successfully DELETED');
    }
    public function deletemajor($id)
    {
        $major = Major::getId($id);

        $major->deleted = 2;
        $major->save();
        return redirect()->back()->with('success', 'Major successfully DELETED');
    }
}
