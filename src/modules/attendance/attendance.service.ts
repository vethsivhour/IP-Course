import { Injectable } from '@nestjs/common';
import { Attendance } from './attendance.entity';
import { Student } from '../student/student.entity';
import { MarkAttendanceInput } from './dto/create-attendance.input';


@Injectable()
export class AttendanceService {
  private records: Attendance[] = [];

  mark(input: MarkAttendanceInput): Attendance {
    this.records.push(input);
    return input;
  }

  remove(session: string, student_id: number): boolean {
    const index = this.records.findIndex(
      (a) => a.session === session && a.student_id === student_id
    );
    if (index >= 0) {
      this.records.splice(index, 1);
      return true;
    }
    return false;
  }

  countByClass(className: string, students: Student[]): number {
    const studentIds = students
      .filter((s) => s.class === className)
      .map((s) => s.id);
    return this.records.filter((a) => studentIds.includes(a.student_id)).length;
  }

  countByStudent(student_id: number): number {
    return this.records.filter((a) => a.student_id === student_id).length;
  }
}