#include <iostream>
#include <fstream>
#include <thread>
#include <mutex>
#include <string>

const char* log_filename = "error_log.txt";
const char* error_file1 = "error1.txt";
const char* error_file2 = "error2.txt";
std::mutex mtx;

void log_error(const std::string& error_msg) {
    mtx.lock();
    std::ofstream log_file(log_filename, std::ios_base::app);
    log_file << error_msg << std::endl;
    log_file.close();
}

std::string read_error_from_file(const char* filename) {
    std::ifstream error_file(filename);
    std::string error_msg;
    std::getline(error_file, error_msg);
    return error_msg;
}

void vulnerable_function1() {
    char error_msg[32]; 
    read_error_from_file(error_file1, error_msg, sizeof(error_msg));
    log_error(error_msg);
}

void vulnerable_function2() {
    char error_msg[32]; 
    read_error_from_file(error_file2, error_msg, sizeof(error_msg));
    log_error(error_msg);
}

int main() {
    std::thread t1(vulnerable_function1);
    std::thread t2(vulnerable_function2);

    t1.join();
    t2.join();

    std::cout << "Error messages logged." << std::endl;

    return 0;
}