<?php

class Dummy_data
{
    public $castes;
    public $area;
    public $income;
    public function __construct()
    {
        $caste_file = RPATH . "/data/json/caste/caste.json";
        $location_file = RPATH . "/data/json/india/states-and-districts.json";
        $income_file = RPATH . "/data/json/income/income.json";

        $this->castes = json_decode(file_get_contents($caste_file));
        $this->area = json_decode(file_get_contents($location_file), true);
        $this->income = json_decode(file_get_contents($income_file));
    }

    function generate_user()
    {

        $fnamesF = [
            "Aaradhya", "Aditi", "Aishwarya", "Akanksha", "Ananya", "Anjali", "Bhavna", "Chhavi", "Deepika", "Divya",
            "Esha", "Gauri", "Ishita", "Jhanvi", "Kavya", "Khushi", "Mansi", "Meera", "Neha", "Pooja",
            "Priya", "Radhika", "Riya", "Sakshi", "Sanya", "Shreya", "Sneha", "Tanvi", "Trisha", "Vaishnavi",
            "Vidya", "Yashasvi", "Zara", "Aanya", "Amisha", "Anika", "Ayesha", "Charul", "Disha", "Ekta",
            "Falguni", "Gunjan", "Himani", "Ishani", "Juhi", "Kritika", "Manisha", "Megha", "Nidhi", "Nisha",
            "Palak", "Parul", "Poonam", "Preeti", "Rachna", "Riddhi", "Ritika", "Sakina", "Sapna", "Sheetal",
            "Shilpa", "Shivani", "Shubha", "Sonali", "Sunita", "Swati", "Tanya", "Urvashi", "Vandana", "Yamini",
            "Zoya", "Anamika", "Devika", "Indira", "Kiran", "Leela", "Maya", "Naina", "Padmini", "Rani",
            "Roshni", "Sarika", "Seema", "Smita", "Uma", "Vasudha", "Vidhi", "Zara", "Aditya", "Ajay",
            "Akash", "Amar", "Anand", "Anil", "Ankit", "Arjun", "Ashish", "Bhavesh", "Chirag",
        ];
        $fnamesM = [
            "Aarav", "Abhinav", "Aditya", "Ajay", "Akash", "Amar", "Amit", "Anand", "Anil", "Ankit",
            "Arjun", "Ashish", "Bhavesh", "Chirag", "Dheeraj", "Gaurav", "Hitesh", "Ishaan", "Jai", "Karan",
            "Kartik", "Lokesh", "Manish", "Mohit", "Mukesh", "Naveen", "Neeraj", "Nikhil", "Nitesh", "Pankaj",
            "Prakash", "Pranav", "Rajat", "Rahul", "Rajesh", "Rakesh", "Ramesh", "Rohan", "Sachin", "Sameer",
            "Sandeep", "Sanjay", "Sarvesh", "Saurabh", "Shantanu", "Shashank", "Siddharth", "Suresh", "Tarun",
            "Utkarsh", "Varun", "Vicky", "Vineet", "Vikas", "Vinay", "Vivek", "Yash", "Amarjit", "Anupam",
            "Atul", "Chandan", "Deepak", "Devendra", "Dharam", "Govind", "Harish", "Jagdish", "Kapil", "Mahesh",
            "Manoj", "Mukul", "Naresh", "Navin", "Omkar", "Paresh", "Pradeep", "Pramod", "Rajendra", "Raman",
            "Ravi", "Rohit", "Rupesh", "Sanjeev", "Satish", "Shyam", "Subhash", "Sunil", "Surendra", "Sushil",
            "Umesh", "Vimal", "Vishal", "Yuvraj", "Zahir", "Alok", "Asim", "Dev", "Farhan", "Gurdeep", "Jatin"
        ];
        $lnames = [
            "Sharma", "Verma", "Kaur", "Patel", "Gupta", "Choudhary", "Yadav", "Jain", "Sinha", "Mishra",
            "Rai", "Prasad", "Chauhan", "Mehta", "Khan", "Shukla", "Trivedi", "Shah", "Puri", "Biswas",
            "Das", "Mukherjee", "Banerjee", "Bhat", "Rajput", "Thakur", "Reddy", "Nair", "Menon", "Iyer",
            "Pillai", "Rao", "Srinivasan", "Chakraborty", "Malik", "Malhotra", "Chopra", "Arora", "Varghese",
            "Thomas", "Mathew", "George", "Jacob", "Joseph", "Panicker", "Pandit", "Pande", "Rastogi", "Nayak",
            "Naik", "Shirodkar", "Shetty", "Kamath", "Rao", "Rastogi", "Dixit", "Seth", "Balakrishnan", "Menon",
            "Varma", "Kapoor", "Batra", "Sengupta", "Goswami", "Ranganathan", "Krishnan", "Ganguly", "Kulkarni",
            "Kamble", "Bhagat", "Lal", "Saxena", "Jha", "Roy", "Roy Chowdhury", "Bose", "karn"
        ];
        $education = [
            "MBA", "M.Sc.", "BTECH", "B.Ed.", "Graduation", "12th", "Matric"
        ];
        $languages = [
            "Hindi", "Maithili", "English", "Bhojpuri"
        ];
        $jobs = [
            "Graphic Designer", "Web Developer", "Software Developer", "Sales Manage", "Bank PO", "Engineer", "Govt. Teacher", "Pvt Teacher", "Pvt Job", "Business", "Self Employed"
        ];
        $heights = [
            167.67,160,168,165,158,169,170,166.65
        ];

        $father = $fnamesM[array_rand($fnamesM)];
        $mother = $fnamesF[array_rand($fnamesF)];
        $grand_father = $fnamesM[array_rand($fnamesM)];
        $income = $this->income[array_rand($this->income)]->range;
        $edu = $education[array_rand($education)];
        $job = $jobs[array_rand($jobs)];
        $lang = $languages[array_rand($languages)];
        $height = $heights[array_rand($heights)];

        $mixedNames = array_merge(
            array_map(function ($name) {
                return array('gender' => 'f', 'firstname' => $name);
            }, $fnamesF),
            array_map(function ($name) {
                return array('gender' => 'm', 'firstname' => $name);
            }, $fnamesM)
        );
        // Randomly choose a name with its corresponding gender
        $selectedNameArray = $mixedNames[array_rand($mixedNames)];
        $gender = $selectedNameArray['gender'];
        $firstName = $selectedNameArray['firstname'];
        $lastName = $lnames[array_rand($lnames)];

        $allCastes = arr($this->castes->religion[0]->castes);

        $caste = $allCastes[array_rand($allCastes)]->name;

        $email = generate_dummy_email(strtolower($firstName));
        $username = strtolower(generate_username_by_email($email));
        $mobile = time();
        $dob = date("Y-m-d", mt_rand(strtotime("1980-01-01"), strtotime("2003-12-31")));

        $casteDetail = "Some caste details";
        $area = $this->area;
        $randomState = $area['states'][array_rand($area['states'])];

        // Randomly choose a district from the selected state
        $city = $randomState['districts'][array_rand($randomState['districts'])];
        $state = $randomState['state'];

        $country = "India";

        $userData = [
            'username' => $username,
            'email' => $email,
            'mobile' => $mobile,
            'occupation' => $job,
            'education' => $edu,
            'annual_income' => $income,
            'height' => $height,
            'language' => $lang,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'dob' => $dob,
            'father' => "{$father} {$lastName}",
            'mother' => "{$mother} {$lastName}",
            'grand_father' => "{$grand_father} {$lastName}",
            'caste' => $caste,
            'caste_detail' => $casteDetail,
            'mool' => null,
            'state' => $state,
            'city' => $city,
            'country' => $country,
            'password' => md5(123),
            'is_active' => 1,
            'is_public' => 1
        ];

        return obj($userData);
    }
}
