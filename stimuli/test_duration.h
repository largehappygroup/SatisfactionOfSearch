#ifndef DATE_CALCULATOR_H
#define DATE_CALCULATOR_H

#include <iostream>
#include <fstream>
#include <string>
#include <sstream>
#include <chrono>
#include <ctime>

using namespace std;
using namespace std::chrono;
using namespace std::chrono_literals;

// Parses a date string and returns a time_point object
system_clock::time_point parseDate(const string& dateStr);

#endif // DATE_CALCULATOR_H
