#include "test_duration.h"
#include <iostream>
#include <fstream>
#include <string>
#include <sstream>
#include <chrono>
#include <ctime>

using namespace std;
using namespace std::chrono;
using namespace std::chrono_literals;

system_clock::time_point parseDate(const string& dateStr) {
    tm dateTm = {};
    stringstream ss(dateStr);
    ss >> get_time(&dateTm, "%Y-%m-%d");
    return system_clock::from_time_t(mktime(&dateTm));
}

int main() {
    char date[16];
    ifstream file("dates.txt"); // dates formatted as '2011-01-01'

    if (!file) {
        cout << "Error: could not open log file." << endl;
        return 1;
    }

    system_clock::time_point prevDate;
    bool firstDate = true;
    int totalDays = 0;

    while (file.getline(date, sizeof(date))) {
        string dateStr(date);
        system_clock::time_point currentDate = parseDate(dateStr);

        if (!firstDate) {
            totalDays ++;
        } else {
            firstDate = false;
        }
        prevDate = currentDate;
    }

    file.close();

    cout << "Total days between dates: " << totalDays << endl;
    return 0;
}
