import os
import sys
import pathlib
import datetime

# Script for backing up the idea repository.
# When run, the result goes in /home/myusername/idea-repo-backups.
# My account runs this script every minute, go to /home/splauritzen/idea-repo-backups
# if you need an old version of the idea repository.
# Written 10-18-24 SL.

def log(message: str):
    now = datetime.datetime.now()
    for line in message.splitlines():
        print(f"[{now}] {line.strip()}")

IDEA_REPOSITORY = pathlib.Path("/var/www/html/idea-repository")
if not IDEA_REPOSITORY.exists():
    log("!!! RED ALERT: THE IDEA REPO IS GONE !!!\n")
    exit(1)

if "HOME" in os.environ:
    MY_FOLDER = pathlib.Path(os.environ["HOME"])
else:
    MY_FOLDER = pathlib.Path("/does/not/exist")

if not MY_FOLDER.exists():
    log("User folder not found.")
    exit(1)

BACKUP_FOLDER = MY_FOLDER.joinpath("idea-repo-backups")
if not BACKUP_FOLDER.exists():
    os.mkdir(BACKUP_FOLDER)
    with open(BACKUP_FOLDER.joinpath("last_backup_time.txt"), "w+") as fp:
        fp.write("2000-01-01")
    log("Backup folder created.")

def get_last_change_time(path: pathlib.Path):
    
    timestamp = 0
    if not path.exists():
        return None
    if path.is_file:
        timestamp = path.stat().st_mtime
    else:
        latest_time = None
        for file in os.scandir(path):
            edit_time = file.stat().st_mtime
            if edit_time > latest_time:
                latest_time = edit_time
        timestamp = latest_time
    
    return datetime.datetime.fromtimestamp(timestamp)

def set_last_sync_time(time: datetime.datetime):
    try:
        backup_timestamp_path = BACKUP_FOLDER.joinpath("last_backup_time.txt")
        with open(backup_timestamp_path, "w+") as fp:
            fp.write(str(time))
    except Exception:
        log(f"Could not save timestamp file to {backup_timestamp_path}.")

def get_last_sync_time() -> datetime.datetime:
    try:
        backup_timestamp_path = BACKUP_FOLDER.joinpath("last_backup_time.txt")
        with open(backup_timestamp_path, "r") as fp:
            return datetime.datetime.fromisoformat(fp.readline())
    except Exception:
        log(f"Could not load timestamp file from {backup_timestamp_path}.")
        return datetime.datetime(2000, 1, 1)


def main():
    now = datetime.datetime.now()
    unsaved_progess = get_last_change_time(IDEA_REPOSITORY) - get_last_sync_time()
    unsaved_progess_seconds = max(round(unsaved_progess.total_seconds()), 0)
    if unsaved_progess > datetime.timedelta(seconds=120):
        log(f"Backup needed, {unsaved_progess_seconds} seconds of unsaved progress.")
        log("Performing backup now...")
        set_last_sync_time(now)
        backup_filename = BACKUP_FOLDER.joinpath(str(now).replace(":", "-") + ".zip")
        # No injection attacks, pretty please
        os.system(f'zip -r "{backup_filename}" "{IDEA_REPOSITORY}"')
    else:
        log(f"No backup needed, only {unsaved_progess_seconds} seconds of unsaved progress.")

if __name__ == "__main__":
    main()
